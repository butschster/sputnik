
# ================================================
# Crete a new site for Nginx
# ================================================

mkdir -p {{ $site->publicPath() }}
cat > {{ $site->publicPath() }}/index.php << EOF

@include('scripts.tools.webserver.template')


EOF

# Write The Nginx Server Block For The Site
rm -f "/etc/nginx/sites-available/{{ $site->domain }}"

touch /etc/nginx/sites-available/{{ $site->domain }}
cat > /etc/nginx/sites-available/{{ $site->domain }} << EOF
include configs/{{ $site->domain }}/before/*;
server {
    listen 80;
    listen [::]:80;
    server_name {{ $site->domain }};
    root {{ $site->publicPath() }};

    # ssl_certificate;
    # ssl_certificate_key;
    ssl_protocols TLSv1.2;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-SHA384;
    ssl_prefer_server_ciphers on;
    ssl_dhparam /etc/nginx/dhparams.pem;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;
    include configs/{{ $site->domain }}/server/*;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    access_log off;
    error_log  /var/log/nginx/{{ $site->domain }}-error.log error;

    error_page 404 /index.php;
    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php/php{{ $configurator->php()->humanReadableVersion() }}-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
include configs/{{ $site->domain }}/after/*;

EOF

# Write The Configuration Directories

@foreach(['before', 'after', 'server'] as $folder)
mkdir -p {{ $config->configPath($site, $folder) }}
@endforeach

# Enable The Nginx Sites

rm -f "/etc/nginx/sites-enabled/{{ $site->domain }}"
ln -s /etc/nginx/sites-available/{{ $site->domain }} /etc/nginx/sites-enabled/{{ $site->domain }}

# Write The Base Redirector For The Site

rm -f /etc/nginx/configs/{{ $site->domain }}/before/redirect.conf
rm -f /etc/nginx/configs/{{ $site->domain }}/before/ssl_redirect.conf

cat > /etc/nginx/configs/{{ $site->domain }}/before/redirect.conf << EOF
server {
    listen 80;
    listen [::]:80;
    server_name www.{{ $site->domain }};
    return 301 \$scheme://{{ $site->domain }}\$request_uri;
}

EOF

@include('scripts.tools.webserver.nginx.restart')
{!! $configurator->php()->restart() !!}
