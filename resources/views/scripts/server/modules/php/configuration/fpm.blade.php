
# ================================================
# Configure PHP FPM
# ================================================
cat > /etc/php/{!! $version !!}/fpm/php.ini << EOF
{!! file_get_contents(resource_path('views/scripts/server/modules/php/configuration/fpm.ini')) !!}

EOF

# ================================================
# Configure FPM Pool
# ================================================
cat > /etc/php/{!! $version !!}/fpm/pool.d/www.conf << EOF
{!! file_get_contents(resource_path('views/scripts/server/modules/php/configuration/www.conf')) !!}

EOF

# ================================================
# Restart PHP-FPM Services
# ================================================
if [ ! -z "\$(ps aux | grep php-fpm | grep -v grep)" ]
then
systemctl restart php{!! $version !!}-fpm > /dev/null 2>&1
fi
