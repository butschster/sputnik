<?php

return [
    'php' => [
        '72' => [
            'install' => 'tools.php.72.install',
            'remove' => 'tools.php.72.remove',
            'restart' => 'tools.php.72.restart',
        ],
        '73' => [
            'install' => 'tools.php.73.install',
            'remove' => 'tools.php.73.remove',
            'restart' => 'tools.php.73.restart',
        ],
    ],
    'database' => [
        'mysql' => [
            'install' => 'tools.database.mysql.install',
            'remove' => 'tools.database.mysql.remove',
            'restart' => 'tools.database.mysql.restart',
        ],
        'mysql8' => [
            'install' => 'tools.database.mysql8.install',
            'remove' => 'tools.database.mysql8.remove',
            'restart' => 'tools.database.mysql8.restart',
        ],
        'mariadb' => [
            'install' => 'tools.database.mariadb.install',
            'remove' => 'tools.database.mariadb.remove',
            'restart' => 'tools.database.mariadb.restart',
        ],
        'pgsql' => [
            'install' => 'tools.database.pgsql.install',
            'remove' => 'tools.database.pgsql.remove',
            'restart' => 'tools.database.pgsql.restart',
        ],
    ],
    'tools' => [
        'redis' => [
            'install' => 'tools.redis.install',
            'remove' => 'tools.redis.remove',
            'restart' => 'tools.redis.restart',
        ],
        'memcached' => [
            'install' => 'tools.memcached.install',
            'remove' => 'tools.memcached.remove',
            'restart' => 'tools.memcached.restart',
        ],
        'beanstalk' => [
            'install' => 'tools.beanstalk.install',
            'remove' => 'tools.beanstalk.remove',
            'restart' => 'tools.beanstalk.restart',
        ],
    ],
    'webserver' => [
        'nginx' => [
            'install' => 'tools.nginx.install',
            'remove' => 'tools.nginx.remove',
            'restart' => 'tools.nginx.restart',
            'site' =>  'tools.nginx.site',
        ],
        'caddy' => [
            'install' => 'tools.caddy.install',
            'remove' => 'tools.caddy.remove',
            'restart' => 'tools.caddy.restart',
            'site' =>  'tools.caddy.site',
        ],
    ]
];
