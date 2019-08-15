
# ================================================
# PHP {{ $version }}
#
# Documentation: https://www.php.net/
# ================================================
apt-add-repository ppa:ondrej/php -y
apt-get update

apt-get update

{!! $modules !!}

# ================================================
# Deployer
#
# Documentation: https://deployer.org/docs/
# ================================================
curl -LO https://deployer.org/deployer.phar
mv deployer.phar /usr/local/bin/dep
chmod +x /usr/local/bin/dep

# ================================================
# Composer
#
# See https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx
# Documentation: https://getcomposer.org/doc/
# ================================================

curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Configure PHP CLI

cat > /etc/php/{!! $version !!}/cli/php.ini << EOF
{!! file_get_contents(resource_path('views/scripts/tools/php/cli.ini')) !!}

EOF

# Configure PHP FPM

cat > /etc/php/{!! $version !!}/fpm/php.ini << EOF
{!! file_get_contents(resource_path('views/scripts/tools/php/fpm.ini')) !!}

EOF

# Configure FPM Pool

cat > /etc/php/{!! $version !!}/fpm/pool.d/www.conf << EOF
{!! file_get_contents(resource_path('views/scripts/tools/php/www.conf')) !!}

EOF

{!! $config->restart() !!}

# Configure Sudoers Entries

@foreach($users as $user)
echo "{{ $user->name }} ALL=NOPASSWD: /usr/sbin/service php{!! $version !!}-fpm reload" > /etc/sudoers.d/php-fpm
@endforeach
