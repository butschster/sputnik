@include('scripts.utils.wait_apt_unlock')

# ================================================
# Redis
#
# Documentation: https://redis.io/documentation
# ================================================
apt-add-repository ppa:chris-lea/redis-server -y
apt-get update

apt-get install -y --force-yes redis-server
sed -i 's/bind 127.0.0.1/bind 0.0.0.0/' /etc/redis/redis.conf

systemctl enable redis-server
systemctl restart redis-server

