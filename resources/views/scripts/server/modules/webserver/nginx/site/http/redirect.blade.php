
server {
    listen 80;
    listen [::]:80;
    server_name www.{{ $site->domain }};
    return 301 \$scheme://{{ $site->domain }}\$request_uri;
}
