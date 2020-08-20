#!/bin/sh
# Configure masquerading, so containers can reach the internet
iptables -t nat -A POSTROUTING -s ${NET_CIRD} -o eth0 -j MASQUERADE

# The virtual service ips should never get routed, if we don't drop them we might get into a "routing loop"
# and even crash the NAT
ip route add blackhole ${PORTAL_CIRD}

# Override the default nameserver, otherwise performance on OSX sucks
#cat << EOF > /etc/resolv.conf
#nameserver 8.8.8.8
#EOF