@if($webserver == 'nginx')
    index index.php;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }
    error_page 404 /index.php;
    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php/{{ $version }}-fpm.sock;
        fastcgi_intercept_errors off;
        fastcgi_index index.php;
        include fastcgi_params;
    }
@endif