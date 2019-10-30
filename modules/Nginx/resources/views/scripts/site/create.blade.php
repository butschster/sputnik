
# ================================================
# Crete a new site for Nginx
# ================================================

mkdir -p {{ $site->getPublicDir() }}

cat > "{{ $site->getPublicDir() }}/index.php" << EOF

@include('Nginx::scripts.site.template')

EOF

# Write The Nginx Server Block For The Site
rm -f "/etc/nginx/sites-available/{{ $site->getDomain() }}"
rm -f "/etc/nginx/sites-available/www.{{ $site->getDomain() }}"

touch /etc/nginx/sites-available/{{ $site->getDomain() }}
cat > /etc/nginx/sites-available/{{ $site->getDomain() }} << EOF
@include('Nginx::scripts.site.http.config')

EOF

# Write The Configuration Directories

@foreach(['before', 'after', 'server'] as $folder)
mkdir -p /etc/nginx/configs/{{ $site->getDomain() }}/{{ ltrim(trim($folder)) }}/
@endforeach

# Enable The Nginx Sites

rm -f "/etc/nginx/sites-enabled/{{ $site->getDomain() }}"
ln -s /etc/nginx/sites-available/{{ $site->getDomain() }} /etc/nginx/sites-enabled/{{ $site->getDomain() }}

rm -f "/etc/nginx/sites-enabled/www.{{ $site->getDomain() }}"


# Write The Base Redirector For The Site

rm -f /etc/nginx/configs/{{ $site->getDomain() }}/before/redirect.conf

cat > /etc/nginx/configs/{{ $site->getDomain() }}/before/redirect.conf << EOF
@include('Nginx::scripts.site.http.redirect')
EOF

@include('Nginx::scripts.nginx.restart')
{!! $processor->createScriptForRestart() !!}
