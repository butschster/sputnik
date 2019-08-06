
# Uninstall Nginx
apt-get purge --auto-remove -y --force-yes nginx*

{!! callback_url('server.event', ['server_id' => $server->id, 'message' => 'nginx.uninstalled'], 10) !!}
