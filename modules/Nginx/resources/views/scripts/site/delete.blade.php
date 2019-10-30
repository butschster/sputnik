
# ================================================
# Remove The Nginx Site
# ================================================
rm "/etc/nginx/sites-enabled/www.{{ $site->getDomain() }}"
rm "/etc/nginx/sites-enabled/{{ $site->getDomain() }}"
rm "/etc/nginx/sites-available/www.{{ $site->getDomain() }}"
rm "/etc/nginx/sites-available/{{ $site->getDomain() }}"

# Remove Configuration Directories

rm -rf "/etc/nginx/configs/{{ $site->getDomain() }}/"
rm -rf "{{ $site->getDir() }}"

# Remove The SSL Certificates
rm -rf "/etc/nginx/ssl/{{ $site->getDomain() }}"

@include('scripts.tools.webserver.nginx.restart')
{!! $processor->createScriptForRestart() !!}
