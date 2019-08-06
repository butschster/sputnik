
# Uninstall Redis
apt-get purge --auto-remove -y --force-yes redis-server

{!! callback_url('server.event', ['server_id' => $server->id, 'message' => 'redis.uninstalled'], 10) !!}
