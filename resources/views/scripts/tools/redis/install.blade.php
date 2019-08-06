
# ================================================
# Redis
#
# Documentation: https://redis.io/documentation
# ================================================
apt-add-repository ppa:chris-lea/redis-server -y
apt-get update

apt-get install -y --force-yes redis-server
sed -i 's/bind 127.0.0.1/bind 0.0.0.0/' /etc/redis/redis.conf
service redis-server restart

{!! callback_url('server.event', ['server_id' => $server->id, 'message' => 'redis.installed'], 10) !!}
