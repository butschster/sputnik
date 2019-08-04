
#!/bin/sh
# Build Formatted Keys & Copy Keys To Forge

if [ ! -d /root/.ssh ]
then
    mkdir -p /root/.ssh
    touch /root/.ssh/authorized_keys
fi

mkdir -p /root/.ssh/authorized_keys.d

while read -r l; do
    curl --insecure --data "event=server.key&key=${l}" {{ route('server.callback', $server) }} > /dev/null 2>&1
done < .ssh/authorized_keys

echo "{!! $server->public_key !!}" > /root/.ssh/authorized_keys.d/server.pub

curl --insecure --data "event=server.keys_installed" {{ route('server.callback', $server) }} > /dev/null 2>&1
