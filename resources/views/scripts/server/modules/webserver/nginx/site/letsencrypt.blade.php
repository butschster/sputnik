
certbot certonly --nginx --non-interactive --agree-tos -m ssl@sputnikcloud.com --cert-name sputnikcloud.com --cert-path /etc/nginx/ssl/sputnikcloud.com/server.crt --key-path /etc/nginx/ssl/sputnikcloud.com/server.key  -d sputnikcloud.com  -d www.sputnikcloud.com

sed -i "s/listen 80;/d" /etc/nginx/sites-available/{{ $site->domain }}
sed -i "s/listen \[::\]:80;/d" /etc/nginx/sites-available/{{ $site->domain }}

# Replace Forge SSL Stubs

sed -i -r "s/# ssl_certificate_key.*/ssl_certificate_key \/etc\/nginx\/ssl\/superprojects.space\/598643\/server.key;/" /etc/nginx/sites-available/superprojects.space
sed -i -r "s/# ssl_certificate.*/ssl_certificate \/etc\/nginx\/ssl\/superprojects.space\/598643\/server.crt;/" /etc/nginx/sites-available/superprojects.space

# Write The SSL Redirect

rm -f "/etc/nginx/configs/{{ $site->domain }}/before/redirect.conf"
rm -f "/etc/nginx/configs/{{ $site->domain }}/before/ssl_redirect.conf"

cat > /etc/nginx/configs/{{ $site->domain }}/before/ssl_redirect.conf << EOF
# Redirect every request to HTTPS...
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

    # FORGE SSL (DO NOT REMOVE!)
    ssl_certificate /etc/nginx/ssl/{{ $site->domain }}/server.crt;
    ssl_certificate_key /etc/nginx/ssl/{{ $site->domain }}/server.key;
    ssl_protocols TLSv1.2;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-SHA384;
    ssl_prefer_server_ciphers on;
    ssl_dhparam /etc/nginx/dhparams.pem;
    server_name www.{{ $site->domain }};
    return 301 https://{{ $site->domain }}\$request_uri;
}
EOF