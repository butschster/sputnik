
# Remove PHP 7.3
apt-get purge -y --force-yes --auto-remove php7.3-common

{!! callback_url('server.event', ['server_id' => $server->id, 'message' => 'php73.uninstalled'], 10) !!}
