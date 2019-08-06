
# Remove PHP 7.2
apt-get purge -y --force-yes --auto-remove php7.2-common

{!! callback_url('server.event', ['server_id' => $server->id, 'message' => 'php72.uninstalled'], 10) !!}

