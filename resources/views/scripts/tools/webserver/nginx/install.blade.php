
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
{!! file_get_contents(resource_path('views/scripts/tools/webserver/nginx/gzip.conf')) !!}

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

@include('scripts.tools.webserver.nginx.restart')

# TODO remove
if [ ! -z "\$(ps aux | grep php-fpm | grep -v grep)" ]
then
    service php7.3-fpm restart > /dev/null 2>&1
fi

# Add Sputnik User To www-data Group

usermod -a -G www-data sputnik
id sputnik
groups sputnik

cat > /etc/nginx/fastcgi_params << EOF
fastcgi_param   QUERY_STRING        \$query_string;
fastcgi_param   REQUEST_METHOD      \$request_method;
fastcgi_param   CONTENT_TYPE        \$content_type;
fastcgi_param   CONTENT_LENGTH      \$content_length;
fastcgi_param   SCRIPT_FILENAME     \$request_filename;
fastcgi_param   SCRIPT_NAME         \$fastcgi_script_name;
fastcgi_param   REQUEST_URI         \$request_uri;
fastcgi_param   DOCUMENT_URI        \$document_uri;
fastcgi_param   DOCUMENT_ROOT       \$document_root;
fastcgi_param   SERVER_PROTOCOL     \$server_protocol;
fastcgi_param   GATEWAY_INTERFACE   CGI/1.1;
fastcgi_param   SERVER_SOFTWARE     nginx/\$nginx_version;
fastcgi_param   REMOTE_ADDR         \$remote_addr;
fastcgi_param   REMOTE_PORT         \$remote_port;
fastcgi_param   SERVER_ADDR         \$server_addr;
fastcgi_param   SERVER_PORT         \$server_port;
fastcgi_param   SERVER_NAME         \$server_name;
fastcgi_param   HTTPS               \$https if_not_empty;
fastcgi_param   REDIRECT_STATUS     200;
fastcgi_param   HTTP_PROXY  "";
EOF

# Generate dhparams File If Necessary
if [ ! -f /etc/nginx/dhparams.pem ]
then
    openssl dhparam -out /etc/nginx/dhparams.pem 2048
fi
