#!/bin/sh

{!! $osInformation !!}

if [ ! -d /root/.ssh ]
then
    mkdir -p /root/.ssh
    touch /root/.ssh/authorized_keys
fi

mkdir -p /root/.ssh/authorized_keys.d

while read -r l; do
    {!! callback_url('server.key', ['server_id' => $server->id, 'key' => '${l}'], 10)  !!}
done < .ssh/authorized_keys

echo "{!! $server->public_key !!}" > /root/.ssh/authorized_keys.d/server.pub
echo "{!! $server->public_key !!}" >> /root/.ssh/authorized_keys

{!! callback_url('server.keys_installed', [
    'server_id' => $server->id
], 10) !!}
