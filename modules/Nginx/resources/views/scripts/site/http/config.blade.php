include configs/{{ $site->getDomain() }}/before/*;
server {
    listen {{ $site->getPort() }};
    listen [::]:{{ $site->getPort() }};
    server_name {{ $site->getDomain() }};
    root {{ $site->getPublicDir() }};

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    charset utf-8;
    include configs/{{ $site->getDomain() }}/server/*;

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    access_log off;
    error_log  /var/log/nginx/{{ $site->getDomain() }}-error.log error;

    {!! $processor->createScriptForWebServer('nginx', $site) !!}

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
include configs/{{ $site->getDomain() }}/after/*;
