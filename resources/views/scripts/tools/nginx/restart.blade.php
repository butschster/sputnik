
# Restart Nginx Service
service nginx reload

{!! callback_url('server.event', ['server_id' => $server->id, 'message' => 'nginx.restarted'], 10) !!}
