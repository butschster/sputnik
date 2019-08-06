
# ================================================
# Nginx
#
# See https://laravel.com/docs/5.6/deployment
# Documentation: https://nginx.ru/en/docs/
# ================================================
apt-add-repository ppa:nginx/development -y
apt-get update

apt-get install -y --force-yes nginx

systemctl enable nginx.service

# Configure Gzip

cat > /etc/nginx/conf.d/gzip.conf << EOF
{!! file_get_contents(resource_path('views/scripts/tools/nginx/gzip.conf')) !!}

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

@include('scripts.tools.nginx.restart')

# TODO remove
if [ ! -z "\$(ps aux | grep php-fpm | grep -v grep)" ]
then
    service php7.3-fpm restart > /dev/null 2>&1
fi

# Add Sputnik User To www-data Group

usermod -a -G www-data sputnik
id sputnik
groups sputnik

{!! callback_url('server.event', ['server_id' => $server->id, 'message' => 'nginx.installed'], 10) !!}
