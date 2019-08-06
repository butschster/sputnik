
# ================================================
# PHP
#
# Documentation: https://www.php.net/
# ================================================
apt-add-repository ppa:ondrej/php -y
apt-get update

apt-get update

apt-get install -y --force-yes php7.2-cli php7.2-dev \
php7.2-pgsql php7.2-sqlite3 php7.2-gd \
php7.2-curl php7.2-memcached \
php7.2-imap php7.2-mysql php7.2-mbstring \
php7.2-xml php7.2-zip php7.2-bcmath php7.2-soap \
php7.2-intl php7.2-readline

# ================================================
# Composer
#
# See https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx
# Documentation: https://getcomposer.org/doc/
# ================================================

curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Configure PHP CLI

cat > /etc/php/7.2/cli/php.ini << EOF
{!! file_get_contents(resource_path('views/scripts/tools/php/cli.ini')) !!}

EOF

# Configure PHP FPM

cat > /etc/php/7.2/fpm/php.ini << EOF
{!! file_get_contents(resource_path('views/scripts/tools/php/fpm.ini')) !!}

EOF

# Configure FPM Pool

cat > /etc/php/7.2/fpm/pool.d/www.conf << EOF
{!! file_get_contents(resource_path('views/scripts/tools/php/www.conf')) !!}

EOF

# Restart FPM

service php7.2-fpm restart > /dev/null 2>&1

# Configure Sudoers Entries

echo "sputnik ALL=NOPASSWD: /usr/sbin/service php7.2-fpm reload" > /etc/sudoers.d/php-fpm

{!! callback_url('server.event', ['server_id' => $server->id, 'message' => 'php72.installed'], 10) !!}
