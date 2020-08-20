#!/usr/bin/env bash
set -euv -o pipefail

ETCD_VERSION=3.3.2
KUBERNETES_VERSION=1.10.0
DOCKER_VERSION=18.03.0

KUBERNETES_SERVER_SHA256=f2e0505bee7d9217332b96be11d1b88c06f51049f7a44666b0ede80bfb92fdf6

NET_CIRD=10.10.0.0/24
DOCKER_CIRD=10.10.0.128/25

BRIDGE_IP=10.10.0.2
BRIDGE_MASK=255.255.255.0

PORTAL_CIRD=10.0.0.0/24
CLUSTERDNS_IP=10.0.0.10
DNS_DOMAIN=k8s.local

# Overwrite Vboxnameserver because of bad performance on OSX
echo "supersede domain-name-servers 8.8.8.8, 8.8.4.4;" >> /etc/dhcp/dhclient.conf
printf "nameserver 8.8.8.8\nnameserver 8.8.4.4\n" > /etc/resolv.conf

# Disable all docker networking stuff, we will set it up manually
mkdir -p /etc/docker/
sed -e "s%\${DOCKER_CIRD}%${DOCKER_CIRD}%g" /vagrant/conf/daemon.json > /etc/docker/daemon.json

# Setup the bridge for docker, we connect it with the VirtualBox network (eth1)
sed -e "s%\${BRIDGE_IP}%${BRIDGE_IP}%g" -e "s%\${BRIDGE_MASK}%${BRIDGE_MASK}%g" /vagrant/conf/cbr0 > /etc/network/interfaces.d/cbr0

cp /vagrant/conf/vagrant-startup.service /etc/systemd/system/vagrant-startup.service

sed -e "s%\${NET_CIRD}%${NET_CIRD}%g" -e "s%\${PORTAL_CIRD}%${PORTAL_CIRD}%g" /vagrant/conf/vagrant-startup.sh > /usr/bin/vagrant-startup
chmod +x /usr/bin/vagrant-startup
systemctl enable vagrant-startup
systemctl start vagrant-startup

## Configure journald
mkdir -p /var/log/journal
chgrp systemd-journal /var/log/journal
chmod g+rwx /var/log/journal
echo "SystemMaxUse=256M" >> /etc/systemd/journald.conf
# Give the vagrant user full access to the journal
usermod -a -G systemd-journal vagrant
# Remove rsyslog
apt-get --quiet --yes purge rsyslog

apt-get --quiet update
apt-get --quiet --yes install apt-transport-https


# docker
echo "deb https://download.docker.com/linux/debian stretch stable" > /etc/apt/sources.list.d/docker.list
wget -qO- https://download.docker.com/linux/debian/gpg | apt-key add -

export DEBIAN_FRONTEND=noninteractive

systemctl mask docker

apt-get --quiet update
apt-get --quiet --yes dist-upgrade
# Install bridge-utils first, so that we can get the bridget for docker up
apt-get --quiet --yes --no-install-recommends install \
    bridge-utils ethtool htop vim curl \
    docker-ce=${DOCKER_VERSION}~ce-0~debian \
    bindfs # For sysdig # bindfs is for fixing NFS mount permissions

# Add vagrant user to docker group, so that vagrant can user docker without sudo
usermod -aG docker vagrant

if [ ! -f /vagrant/etcd-v${ETCD_VERSION}-linux-amd64.tar.gz ]; then
    curl -sSL  https://github.com/coreos/etcd/releases/download/v${ETCD_VERSION}/etcd-v${ETCD_VERSION}-linux-amd64.tar.gz -o /vagrant/etcd-v${ETCD_VERSION}-linux-amd64.tar.gz
fi
tar xzf /vagrant/etcd-v${ETCD_VERSION}-linux-amd64.tar.gz --strip-components=1 etcd-v${ETCD_VERSION}-linux-amd64/etcd etcd-v${ETCD_VERSION}-linux-amd64/etcdctl
mv etcd etcdctl /usr/bin

if [ ! -f /vagrant/kubernetes-server-v${KUBERNETES_VERSION}.tar.gz ]; then
    curl -sSL https://storage.googleapis.com/kubernetes-release/release/v${KUBERNETES_VERSION}/kubernetes-server-linux-amd64.tar.gz -o  /vagrant/kubernetes-server-v${KUBERNETES_VERSION}.tar.gz
fi
sha256sum /vagrant/kubernetes-server-v${KUBERNETES_VERSION}.tar.gz | grep -q ${KUBERNETES_SERVER_SHA256}
tar -xf /vagrant/kubernetes-server-v${KUBERNETES_VERSION}.tar.gz --strip-components=3 kubernetes/server/bin/kubectl kubernetes/server/bin/hyperkube
rm -rf kubernetes
mv hyperkube kubectl /usr/bin
chmod +x /usr/bin/kubectl /usr/bin/hyperkube

kubectl completion bash > /etc/bash_completion.d/kubectl

cp /vagrant/conf/kubeconfig.yml /etc/kubeconfig.yml

sed -e "s%\${PORTAL_CIRD}%${PORTAL_CIRD}%g" /vagrant/conf/kube-apiserver.service > /etc/systemd/system/kube-apiserver.service
sed -e "s%\${BRIDGE_IP}%${BRIDGE_IP}%g" -e "s%\${CLUSTERDNS_IP}%${CLUSTERDNS_IP}%g" -e "s%\${DNS_DOMAIN}%${DNS_DOMAIN}%g" /vagrant/conf/kubelet.service > /etc/systemd/system/kubelet.service
cp /vagrant/conf/kube-controller-manager.service \
   /vagrant/conf/kube-scheduler.service \
   /vagrant/conf/kube-proxy.service \
   /vagrant/conf/kube-etcd.service \
  /etc/systemd/system/
systemctl enable kubelet kube-apiserver kube-controller-manager kube-scheduler kube-proxy kube-etcd
systemctl start kube-apiserver kube-controller-manager kube-scheduler kube-proxy kube-etcd

mkdir -p /etc/kubernetes/manifests
sed -e "s%\${BRIDGE_IP}%${BRIDGE_IP}%g" /vagrant/conf/kube-master.yml > /etc/kubernetes/manifests/kube-master.yml
sed -e "s%\${DNS_DOMAIN}%${DNS_DOMAIN}%g" -e "s%\${CLUSTERDNS_IP}%${CLUSTERDNS_IP}%g" /vagrant/conf/kube-dns.yml > /etc/kubernetes/manifests/kube-dns.yml
cp /vagrant/conf/kube-dashboard.yml /etc/kubernetes/manifests/kube-dashboard.yml

echo "Waiting for API server to show up"
until $(curl --output /dev/null --silent --head --fail http://localhost:8080); do
    printf '.'
    sleep 1
done

# Give it a bit more time to load everything
sleep 2

kubectl apply -f /etc/kubernetes/manifests/kube-master.yml
kubectl apply -f /etc/kubernetes/manifests/kube-dns.yml
kubectl apply -f /etc/kubernetes/manifests/kube-dashboard.yml

kubectl --namespace kube-system run --image flixtech/k8s-mdns:0.2 k8s-mdns

# Clear tmp dir, because otherwise vagrant user would not have access
# See kubectl apply --schema-cache-dir=
rm -rf /tmp/kubectl.schema/

# Create bindfs related folders for fixing NFS mount permissions
mkdir /www-data
mkdir /nfs-data
# Add fstab line to auto-start bindfs relation when box starts
echo "bindfs#/nfs-data    /www-data    fuse    force-user=www-data,force-group=www-data    0    0" >> /etc/fstab

cat >> /etc/bash.bashrc << EOF
# enable bash completion in interactive shells
if ! shopt -oq posix; then
  if [ -f /usr/share/bash-completion/bash_completion ]; then
    . /usr/share/bash-completion/bash_completion
  elif [ -f /etc/bash_completion ]; then
    . /etc/bash_completion
  fi
fi
EOF

# Enable memory cgroups
sed -i -e 's/GRUB_CMDLINE_LINUX_DEFAULT="/GRUB_CMDLINE_LINUX_DEFAULT="cgroup_enable=memory /' /etc/default/grub
update-grub

mkdir /sock/
chown vagrant /sock/
#echo 'ln $SSH_AUTH_SOCK /sock/sock' >> /home/vagrant/.bashrc

systemctl unmask docker
