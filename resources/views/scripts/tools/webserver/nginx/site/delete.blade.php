
# ================================================
# Remove The Nginx Site
# ================================================
rm "/etc/nginx/sites-enabled/www.{{ $site->domain }}"
rm "/etc/nginx/sites-enabled/{{ $site->domain }}"
rm "/etc/nginx/sites-available/www.{{ $site->domain }}"
rm "/etc/nginx/sites-available/{{ $site->domain }}"

# Remove Configuration Directories

rm -rf "{{ $config->configPath($site) }}"
rm -rf "{{ $site->path() }}"

# Remove The SSL Certificates
rm -rf "/etc/nginx/ssl/{{ $site->domain }}"

@include('scripts.tools.webserver.nginx.restart')
{!! $configurator->php()->restart() !!}
