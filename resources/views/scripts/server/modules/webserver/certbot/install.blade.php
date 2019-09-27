
apt-add-repository universe -y
apt-add-repository ppa:certbot/certbot -y

apt-get update

apt-get install -y --force-yes certbot python-certbot-nginx