index index.html;

@if($webserver == 'nginx')
    location / {
        proxy_pass {{ $site->getProxyAddress() }};
        proxy_set_header Host $host;
    }
@endif