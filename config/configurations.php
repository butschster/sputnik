<?php

return [
    'server_types' => ['webserver', 'openvpn'],
    'os' => [
        'ubuntu' => ['18.04', '18.10', '19.04', '19.10'],
    ],
    'system_users' => ['sputnik'],
    'php' => ['72', '73'],
    'database' => ['mysql', 'mariadb', 'pgsql', 'mysql8'],
    'tools' => ['redis', 'memcached', 'beanstalk'],
    'webserver' => ['nginx'],
];
