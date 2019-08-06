
# ================================================
# PHP
#
# Documentation: https://www.php.net/
# ================================================
apt-add-repository ppa:ondrej/php -y
apt-get update

apt-get update

apt-get install -y --force-yes php7.3-cli php7.3-dev \
php7.3-pgsql php7.3-sqlite3 php7.3-gd \
php7.3-curl php7.3-memcached \
php7.3-imap php7.3-mysql php7.3-mbstring \
php7.3-xml php7.3-zip php7.3-bcmath php7.3-soap \
php7.3-intl php7.3-readline

# ================================================
# Composer
#
# See https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx
# Documentation: https://getcomposer.org/doc/
# ================================================

curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Configure PHP CLI

cat > /etc/php/7.3/cli/php.ini << EOF
{!! file_get_contents(resource_path('views/scripts/tools/php/cli.ini')) !!}

EOF

# Configure PHP FPM

cat > /etc/php/7.3/fpm/php.ini << EOF
{!! file_get_contents(resource_path('views/scripts/tools/php/fpm.ini')) !!}

EOF

# Configure FPM Pool

cat > /etc/php/7.3/fpm/pool.d/www.conf << EOF
{!! file_get_contents(resource_path('views/scripts/tools/php/www.conf')) !!}

EOF

# Restart FPM

service php7.3-fpm restart > /dev/null 2>&1

# Configure Sudoers Entries

echo "sputnik ALL=NOPASSWD: /usr/sbin/service php7.3-fpm reload" > /etc/sudoers.d/php-fpm

{!! callback_url('server.event', ['server_id' => $server->id, 'message' => 'php73.installed'], 10) !!}
