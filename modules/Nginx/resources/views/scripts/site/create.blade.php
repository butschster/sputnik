
# ================================================
# Crete a new site for Nginx
# ================================================

mkdir -p {{ $site->publicPath() }}

cat > "{{ $site->publicPath() }}/index.php" << EOF

@include('Nginx::scripts.site.template')

EOF

# Write The Nginx Server Block For The Site
rm -f "/etc/nginx/sites-available/{{ $site->domain }}"
rm -f "/etc/nginx/sites-available/www.{{ $site->domain }}"

touch /etc/nginx/sites-available/{{ $site->domain }}
cat > /etc/nginx/sites-available/{{ $site->domain }} << EOF
@include('Nginx::scripts.site.http.config')

EOF

# Write The Configuration Directories

@foreach(['before', 'after', 'server'] as $folder)
mkdir -p {{ $config->configPath($site, $folder) }}
@endforeach

# Enable The Nginx Sites

rm -f "/etc/nginx/sites-enabled/{{ $site->domain }}"
ln -s /etc/nginx/sites-available/{{ $site->domain }} /etc/nginx/sites-enabled/{{ $site->domain }}

rm -f "/etc/nginx/sites-enabled/www.{{ $site->domain }}"


# Write The Base Redirector For The Site

rm -f /etc/nginx/configs/{{ $site->domain }}/before/redirect.conf

cat > /etc/nginx/configs/{{ $site->domain }}/before/redirect.conf << EOF
@include('Nginx::scripts.site.http.redirect')
EOF

@include('Nginx::scripts.nginx.restart')
