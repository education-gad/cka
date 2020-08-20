#!/usr/bin/env bash

FILE=$1
VERSION=$2

if [[ "$OSTYPE" == darwin* ]]; then
    CHECKSUM=`shasum -a 256 ${FILE} | cut -f 1 -d ' '`
else
    CHECKSUM=`sha256sum ${FILE} | cut -f 1 -d ' '`
fi

cat << EOF > $3
{
  "name": "https://vbox.example.com/kubernetes.json",
  "description": "This box contains a Debian system with Kubernetes installed.",
  "versions": [{
    "version": "${VERSION}",
    "providers": [{
      "name": "virtualbox",
      "url": "https://vbox.example.com/debian-jessie-kubernetes-amd64-${VERSION}.box",
      "checksum_type": "sha256",
      "checksum": "${CHECKSUM}"
    }]
  }]
}
EOF
