<?php

return [
    'section' => [
        'mysql56' => 'Управление MySQL 5.6',
        'mysql8' => 'Управление MySQL 8',
        'mariadb' => 'Управление MariaDB',
    ],
    'title' => [
        'mysql56' => 'Управление MySQL 5.6',
        'mysql8' => 'Управление MySQL 8',
        'mariadb' => 'Управление MariaDB',
    ],
    'database' => [
        'title' => 'Созданные БД',
        'table' => [
            'name' => 'Название БД',
            'user' => 'Пользователь',
            'password' => 'Пароль',
            'status' => 'Статус',
        ],
        'form' => [
            'create' => [
                'title' => 'Создать БД',
                'description' => 'Вы можете с легкостью управлять БД на вашем сервере.',
                'name' => 'Название',
                'password' => 'Пароль',
                'character_set' => 'Кодировка',
                'submit' => 'Создать',
            ],
        ],
        'message' => [
            'empty_list' => 'Похоже у вас не создано ни одной базы данных',
            'created' => 'База данных успешно создана!',
            'deleted' => 'База данных успешно удалена!',
        ],
    ],
];