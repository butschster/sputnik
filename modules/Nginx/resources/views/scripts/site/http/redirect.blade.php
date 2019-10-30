
server {
    listen {{ $site->getPort() }};
    listen [::]:{{ $site->getPort() }};
    server_name www.{{ $site->getDomain() }};
    return 301 \$scheme://{{ $site->getDomain() }}\$request_uri;
}
