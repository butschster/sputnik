#
# REQUIRES:
#       - server (the forge server instance)
#       - event (the forge event instance)
#       - sudo_password (random password for sudo)
#       - db_password (random password for database user)
#       - callback (the callback URL)
#       - recipe_id (recipe id to run at the end)
#

sudo sed -i "s/#precedence ::ffff:0:0\/96  100/precedence ::ffff:0:0\/96  100/" /etc/gai.conf

# Upgrade The Base Packages

export DEBIAN_FRONTEND=noninteractive

apt-get update
apt-get upgrade -y

# Add A Few PPAs To Stay Current

apt-get install -y --force-yes software-properties-common

# apt-add-repository ppa:fkrull/deadsnakes-python2.7 -y
apt-add-repository ppa:nginx/development -y
apt-add-repository ppa:chris-lea/redis-server -y
apt-add-repository ppa:ondrej/apache2 -y

	apt-add-repository ppa:ondrej/php -y

# Setup MariaDB Repositories



# Update Package Lists

apt-get update
# Base Packages

add-apt-repository universe

apt-get install -y --force-yes build-essential curl fail2ban gcc git libmcrypt4 libpcre3-dev \
make python2.7 python-pip sendmail supervisor ufw unattended-upgrades unzip whois zsh ncdu

# Install Python Httpie

pip install httpie

# Disable Password Authentication Over SSH

sed -i "/PasswordAuthentication yes/d" /etc/ssh/sshd_config
echo "" | sudo tee -a /etc/ssh/sshd_config
echo "" | sudo tee -a /etc/ssh/sshd_config
echo "PasswordAuthentication no" | sudo tee -a /etc/ssh/sshd_config

# Restart SSH

ssh-keygen -A
service ssh restart

# Set The Hostname If Necessary


echo "red-chasm" > /etc/hostname
sed -i 's/127\.0\.0\.1.*localhost/127.0.0.1	red-chasm.localdomain red-chasm localhost/' /etc/hosts
hostname red-chasm


# Set The Timezone

# ln -sf /usr/share/zoneinfo/UTC /etc/localtime
ln -sf /usr/share/zoneinfo/UTC /etc/localtime

# Create The Root SSH Directory If Necessary

if [ ! -d /root/.ssh ]
then
	mkdir -p /root/.ssh
	touch /root/.ssh/authorized_keys
fi

# Setup Forge User

useradd forge
mkdir -p /home/forge/.ssh
mkdir -p /home/forge/.forge
adduser forge sudo

# Setup Bash For Forge User

chsh -s /bin/bash forge
cp /root/.profile /home/forge/.profile
cp /root/.bashrc /home/forge/.bashrc

# Set The Sudo Password For Forge

PASSWORD=$(mkpasswd jSqm0k4EsGjnv7mJ8oBY)
usermod --password $PASSWORD forge

# Build Formatted Keys & Copy Keys To Forge

if [ ! -d /root/.ssh ]
then
	mkdir -p /root/.ssh
	touch /root/.ssh/authorized_keys
fi


cat > /root/.ssh/authorized_keys << EOF
# Laravel Forge
ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDYlmATs0kV9aPQdCqaF12x8Bv0H5jIH2wfCzfpASB8oaRQOC2UerO/ukqtFzko9u5pqTb94bHG7MsQAjtJR13EcMAIOYxuNBEgMNVtJ6EJzklcxBRG9xKIZD6xiVdlxOBgguY72Yv8TkteeDPeN2YyqVx+HgRjqL0zwgFbVx8wlylQU1Gg8WDTERCdYX5jHmfdMN7IiIEYOw4F1U1eJTreexvid68X6OFHrWHAJhJXu8c/Q1d1UgWkHImN9IgHju6HPbge2D2W12UlpLw/FUGM1hNsfkLRwFLnPMnkBVsM27et+H4OdDEt52LtFfJuWKfWcAsrSzIjTCiXEcYsFjRh worker@forge.laravel.com
EOF


cp /root/.ssh/authorized_keys /home/forge/.ssh/authorized_keys

# Create The Server SSH Key

ssh-keygen -f /home/forge/.ssh/id_rsa -t rsa -N ''

# Copy Source Control Public Keys Into Known Hosts File

ssh-keyscan -H github.com >> /home/forge/.ssh/known_hosts
ssh-keyscan -H bitbucket.org >> /home/forge/.ssh/known_hosts
ssh-keyscan -H gitlab.com >> /home/forge/.ssh/known_hosts

# Configure Git Settings

git config --global user.name "Igor"
git config --global user.email "igorvdonsk@yandex.ru"

# Add The Reconnect Script Into Forge Directory

cat > /home/forge/.forge/reconnect << EOF
#!/usr/bin/env bash

echo "# Laravel Forge" | tee -a /home/forge/.ssh/authorized_keys > /dev/null
echo \$1 | tee -a /home/forge/.ssh/authorized_keys > /dev/null

echo "# Laravel Forge" | tee -a /root/.ssh/authorized_keys > /dev/null
echo \$1 | tee -a /root/.ssh/authorized_keys > /dev/null

echo "Keys Added!"
EOF

# Setup Forge Home Directory Permissions

chown -R forge:forge /home/forge
chmod -R 755 /home/forge
chmod 700 /home/forge/.ssh/id_rsa

# Setup UFW Firewall

ufw allow 22
ufw allow 80
ufw allow 443
ufw --force enable

# Allow FPM Restart

echo "forge ALL=NOPASSWD: /usr/sbin/service php7.3-fpm reload" > /etc/sudoers.d/php-fpm
echo "forge ALL=NOPASSWD: /usr/sbin/service php7.2-fpm reload" >> /etc/sudoers.d/php-fpm
echo "forge ALL=NOPASSWD: /usr/sbin/service php7.1-fpm reload" >> /etc/sudoers.d/php-fpm
echo "forge ALL=NOPASSWD: /usr/sbin/service php7.0-fpm reload" >> /etc/sudoers.d/php-fpm
echo "forge ALL=NOPASSWD: /usr/sbin/service php5.6-fpm reload" >> /etc/sudoers.d/php-fpm
echo "forge ALL=NOPASSWD: /usr/sbin/service php5-fpm reload" >> /etc/sudoers.d/php-fpm

	# Install Base PHP Packages


apt-get install -y --force-yes php7.3-cli php7.3-dev \
php7.3-pgsql php7.3-sqlite3 php7.3-gd \
php7.3-curl php7.3-memcached \
php7.3-imap php7.3-mysql php7.3-mbstring \
php7.3-xml php7.3-zip php7.3-bcmath php7.3-soap \
php7.3-intl php7.3-readline


# Install Composer Package Manager

curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Misc. PHP CLI Configuration

sudo sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.3/cli/php.ini
sudo sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.3/cli/php.ini
sudo sed -i "s/memory_limit = .*/memory_limit = 512M/" /etc/php/7.3/cli/php.ini
sudo sed -i "s/;date.timezone.*/date.timezone = UTC/" /etc/php/7.3/cli/php.ini

# Configure Sessions Directory Permissions

chmod 733 /var/lib/php/sessions
chmod +t /var/lib/php/sessions

# Write Systemd File For Linode



	#
# REQUIRES:
#       - server (the forge server instance)
#		- site_name (the name of the site folder)
#

# Install Nginx & PHP-FPM

	apt-get install -y --force-yes nginx php7.3-fpm

systemctl enable nginx.service

# Generate dhparam File

openssl dhparam -out /etc/nginx/dhparams.pem 2048

# Tweak Some PHP-FPM Settings

sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.3/fpm/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.3/fpm/php.ini
sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php/7.3/fpm/php.ini
sed -i "s/memory_limit = .*/memory_limit = 512M/" /etc/php/7.3/fpm/php.ini
sed -i "s/;date.timezone.*/date.timezone = UTC/" /etc/php/7.3/fpm/php.ini

# Configure FPM Pool Settings

sed -i "s/^user = www-data/user = forge/" /etc/php/7.3/fpm/pool.d/www.conf
sed -i "s/^group = www-data/group = forge/" /etc/php/7.3/fpm/pool.d/www.conf
sed -i "s/;listen\.owner.*/listen.owner = forge/" /etc/php/7.3/fpm/pool.d/www.conf
sed -i "s/;listen\.group.*/listen.group = forge/" /etc/php/7.3/fpm/pool.d/www.conf
sed -i "s/;listen\.mode.*/listen.mode = 0666/" /etc/php/7.3/fpm/pool.d/www.conf
sed -i "s/;request_terminate_timeout.*/request_terminate_timeout = 60/" /etc/php/7.3/fpm/pool.d/www.conf

# Configure Primary Nginx Settings

sed -i "s/user www-data;/user forge;/" /etc/nginx/nginx.conf
sed -i "s/worker_processes.*/worker_processes auto;/" /etc/nginx/nginx.conf
sed -i "s/# multi_accept.*/multi_accept on;/" /etc/nginx/nginx.conf
sed -i "s/# server_names_hash_bucket_size.*/server_names_hash_bucket_size 128;/" /etc/nginx/nginx.conf

# Configure Gzip

cat > /etc/nginx/conf.d/gzip.conf << EOF
gzip_comp_level 5;
gzip_min_length 256;
gzip_proxied any;
gzip_vary on;

gzip_types
application/atom+xml
application/javascript
application/json
application/rss+xml
application/vnd.ms-fontobject
application/x-font-ttf
application/x-web-app-manifest+json
application/xhtml+xml
application/xml
font/opentype
image/svg+xml
image/x-icon
text/css
text/plain
text/x-component;

EOF

# Disable The Default Nginx Site

rm /etc/nginx/sites-enabled/default
rm /etc/nginx/sites-available/default
service nginx restart

# Install A Catch All Server

cat > /etc/nginx/sites-available/catch-all << EOF
server {
    return 404;
}
EOF

ln -s /etc/nginx/sites-available/catch-all /etc/nginx/sites-enabled/catch-all

# Restart Nginx & PHP-FPM Services

# Restart Nginx & PHP-FPM Services

#service nginx restart
service nginx reload

if [ ! -z "\$(ps aux | grep php-fpm | grep -v grep)" ]
then
    service php7.3-fpm restart > /dev/null 2>&1
    service php7.2-fpm restart > /dev/null 2>&1
    service php7.1-fpm restart > /dev/null 2>&1
    service php7.0-fpm restart > /dev/null 2>&1
    service php5.6-fpm restart > /dev/null 2>&1
    service php5-fpm restart > /dev/null 2>&1
fi

# Add Forge User To www-data Group

usermod -a -G www-data forge
id forge
groups forge


curl --silent --location https://deb.nodesource.com/setup_10.x | bash -

apt-get update

sudo apt-get install -y --force-yes nodejs

npm install -g pm2
npm install -g gulp
npm install -g yarn

    #
# REQUIRES:
#		- server (the forge server instance)
#		- db_password (random password for mysql user)
#

# Set The Automated Root Password

export DEBIAN_FRONTEND=noninteractive

debconf-set-selections <<< "mysql-community-server mysql-community-server/data-dir select ''"
debconf-set-selections <<< "mysql-community-server mysql-community-server/root-pass password cA3meglsHhZuClGleFHa"
debconf-set-selections <<< "mysql-community-server mysql-community-server/re-root-pass password cA3meglsHhZuClGleFHa"

# Install MySQL

apt-get install -y mysql-server

# Configure Password Expiration

echo "default_password_lifetime = 0" >> /etc/mysql/mysql.conf.d/mysqld.cnf

# Configure Access Permissions For Root & Forge Users

sed -i '/^bind-address/s/bind-address.*=.*/bind-address = */' /etc/mysql/mysql.conf.d/mysqld.cnf
mysql --user="root" --password="cA3meglsHhZuClGleFHa" -e "GRANT ALL ON *.* TO root@'167.71.3.113' IDENTIFIED BY 'cA3meglsHhZuClGleFHa';"
mysql --user="root" --password="cA3meglsHhZuClGleFHa" -e "GRANT ALL ON *.* TO root@'%' IDENTIFIED BY 'cA3meglsHhZuClGleFHa';"
service mysql restart

mysql --user="root" --password="cA3meglsHhZuClGleFHa" -e "CREATE USER 'forge'@'167.71.3.113' IDENTIFIED BY 'cA3meglsHhZuClGleFHa';"
mysql --user="root" --password="cA3meglsHhZuClGleFHa" -e "GRANT ALL ON *.* TO 'forge'@'167.71.3.113' IDENTIFIED BY 'cA3meglsHhZuClGleFHa' WITH GRANT OPTION;"
mysql --user="root" --password="cA3meglsHhZuClGleFHa" -e "GRANT ALL ON *.* TO 'forge'@'%' IDENTIFIED BY 'cA3meglsHhZuClGleFHa' WITH GRANT OPTION;"
mysql --user="root" --password="cA3meglsHhZuClGleFHa" -e "FLUSH PRIVILEGES;"

# Create The Initial Database If Specified

mysql --user="root" --password="cA3meglsHhZuClGleFHa" -e "CREATE DATABASE forge CHARACTER SET utf8 COLLATE utf8_unicode_ci;"


# Install & Configure Redis Server

apt-get install -y redis-server
sed -i 's/bind 127.0.0.1/bind 0.0.0.0/' /etc/redis/redis.conf
service redis-server restart
systemctl enable redis-server
# Install & Configure Memcached

apt-get install -y memcached
sed -i 's/-l 127.0.0.1/-l 0.0.0.0/' /etc/memcached.conf
service memcached restart
# Install & Configure Beanstalk

apt-get install -y --force-yes beanstalkd
sed -i "s/BEANSTALKD_LISTEN_ADDR.*/BEANSTALKD_LISTEN_ADDR=0.0.0.0/" /etc/default/beanstalkd

if grep START= /etc/default/beanstalkd; then
    sed -i "s/#START=yes/START=yes/" /etc/default/beanstalkd
else
    echo "START=yes" >> /etc/default/beanstalkd
fi

service beanstalkd start
sleep 5
service beanstalkd restart

systemctl enable beanstalkd

# Configure Supervisor Autostart

systemctl enable supervisor.service
service supervisor start

# Configure Swap Disk

if [ -f /swapfile ]; then
    echo "Swap exists."
else
    fallocate -l 1G /swapfile
    chmod 600 /swapfile
    mkswap /swapfile
    swapon /swapfile
    echo "/swapfile none swap sw 0 0" >> /etc/fstab
    echo "vm.swappiness=30" >> /etc/sysctl.conf
    echo "vm.vfs_cache_pressure=50" >> /etc/sysctl.conf
fi

# Setup Unattended Security Upgrades

cat > /etc/apt/apt.conf.d/50unattended-upgrades << EOF
Unattended-Upgrade::Allowed-Origins {
    "Ubuntu bionic-security";
};
Unattended-Upgrade::Package-Blacklist {
    //
};
EOF

cat > /etc/apt/apt.conf.d/10periodic << EOF
APT::Periodic::Update-Package-Lists "1";
APT::Periodic::Download-Upgradeable-Packages "1";
APT::Periodic::AutocleanInterval "7";
APT::Periodic::Unattended-Upgrade "1";
EOF

curl --insecure --data "event_id=30041879&server_id=306720&sudo_password=jSqm0k4EsGjnv7mJ8oBY&db_password=cA3meglsHhZuClGleFHa&recipe_id=;" https://forge.laravel.com/provisioning/callback/app
