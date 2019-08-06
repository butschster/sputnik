
# Restart Redis Services

systemctl restart redis

{!! callback_url('server.event', ['server_id' => $server->id, 'message' => 'redis.restarted'], 10) !!}
