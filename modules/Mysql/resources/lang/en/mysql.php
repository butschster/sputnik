<?php

return [
    'section' => [
        'mysql56' => 'MySQL 5.6',
        'mysql8' => 'MySQL 8',
        'mariadb' => 'MariaDB',
    ],
    'title' => [
        'mysql56' => 'MySQL 5.6 management',
        'mysql8' => 'MySQL 8 management',
        'mariadb' => 'MariaDB management',
    ],
    'database' => [
        'title' => 'Create Database',
        'table' => [
            'name' => 'Name',
            'user' => 'User',
            'password' => 'Password',
            'status' => 'Status',
        ],
        'form' => [
            'create' => [
                'title' => 'Create Database',
                'description' => 'You can easily manage your databases on your server.',
                'name' => 'Name',
                'password' => 'Password',
                'character_set' => 'Encoding',
                'submit' => 'Create',
            ],
        ],
        'message' => [
            'empty_list' => 'Looks like you don\'t have any databases yet',
            'created' => 'Database has been successfully created!',
            'deleted' => 'Database has been successfully deleted!',
        ],
    ],
];