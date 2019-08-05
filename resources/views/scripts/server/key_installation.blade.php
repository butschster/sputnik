
#!/bin/sh
# Build Formatted Keys & Copy Keys To Forge

if [ ! -d /root/.ssh ]
then
    mkdir -p /root/.ssh
    touch /root/.ssh/authorized_keys
fi

mkdir -p /root/.ssh/authorized_keys.d

while read -r l; do
    {{ callback_url('server.key', ['server' => $server->id, 'key' => '${l}'], 10) }}
done < .ssh/authorized_keys

echo "{!! $server->public_key !!}" > /root/.ssh/authorized_keys.d/server.pub

{{ callback_url('server.keys_installed', ['server' => $server->id], 10) }}
