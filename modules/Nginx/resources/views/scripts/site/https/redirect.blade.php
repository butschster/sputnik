
server {
    listen 80;
    listen [::]:80;
    server_name .{{ $site->domain }};
    return 301 https://\$host\$request_uri;
}

# Redirect SSL to primary domain SSL...
server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;

    server_name www.{{ $site->domain }};
    return 301 https://{{ $site->domain }}\$request_uri;

    ssl_certificate {{ $site->sslCertPath() }};
    ssl_certificate_key {{ $site->sslKeyPath() }};
    ssl_protocols TLSv1.2;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-SHA384;
    ssl_prefer_server_ciphers on;
    ssl_dhparam /etc/nginx/dhparams.pem;
}