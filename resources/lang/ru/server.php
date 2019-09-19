<?php

return [
    'events' => [
        'title' => 'События',
        'recent' => 'Недавние события',
        'table' => [
            'event' => 'Событие',
            'time' => 'Дата создания',
        ],
        'message' => [
            'empty_results' => 'Похоже на сервере еще ничего не происходило.',
        ],
    ],
    'tasks' => [
        'title' => 'Задачи',
        'recent' => 'Недавно запущенные',
        'table' => [
            'name' => 'Название',
            'status' => 'Статус',
            'time' => 'Дата создания',
        ],
        'status' => [
            'new' => 'Новая',
            'pending' => 'В ожидании',
            'running' => 'Выполняется',
            'finished' => 'Выполнена',
            'timeout' => 'Timeout',
        ],
        'message' => [
            'empty_results' => 'Похоже на сервере еще ничего не запускалось.',
        ],
        'item' => [
            'user' => 'Пользователь',
            'status' => 'Статус',
            'success' => 'Успешна',
            'script' => 'Скрипт',
            'output' => 'Результат выполнения',
        ],
    ],
    'form' => [
        'create' => [
            'title' => 'Подключение сервера',
            'description' => 'Вы можете подключить любой сервер с публичным IP адресом. На сервере должна быть установлена Ubuntu 18.x x64.',
            'label' => [
                'type' => 'Тип сервера',
                'name' => 'Придумайте название',
                'team' => 'Выберите команду',
                'ip' => 'IP адрес сервера',
                'ssh_port' => 'SSH порт',
                'php_version' => 'Версия PHP',
                'database_type' => 'Тип БД',
                'webserver_type' => 'Тип web сервера',
                'vpn_port' => 'Порт подключения',
                'vpn_protocol' => 'Протокол подключения',
                'vpn_dns' => 'Выберите DNS сервер',
            ],
            'button' => [
                'create' => 'Добавить',
            ],
            'message' => [
                'upgrade_subscription' => 'Обновитье подписку для подключения большего кол-ва серверов',
                'created' => 'Сервер успешно добавлен.',
            ],
        ],
    ],
    'list' => [
        'title' => 'Активные сервера',
        'message' => [
            'empty' => 'Похоже вы еще не добавили ни одного сервера.',
        ],
    ],
    'sections' => [
        'title' => 'Сервер',
        'settings' => 'Настройки',
        'events' => 'События',
        'tasks' => 'Задачи',
        'users' => 'Пользователи',
        'firewall' => 'Firewall',
        'supervisor' => 'Supervisor',
        'scheduler' => 'Планировщик',
        'sites' => 'Сайты',
        'database' => 'База данных',
        'vpn_clients' => 'Клиенты VPN',
    ],
    'settings' => [
        'title' => 'Настройки',
        'system_information' => 'Информация о системе',
        'public_key' => [
            'title' => 'Публичный ключ',
            'description' => 'Этот ключ будет автоматически добавлен на Github или Bitbucket, при наличии интеграции с ними. Вы можете вручную добавить данный ключ.',
        ],
        'metadata' => [
            'title' => 'Metadata',
            'form' => [
                'name' => 'Название сервера',
            ],
            'buttons' => [
                'save' => 'Сохранить',
            ],
        ],
    ],
    'destroy' => [
        'title' => 'Удаление сервера',
        'description' => 'Это действие необратимо. Вся информация связанная с сервером будет удалена, но все настройки сервера будут сохранены.',
        'buttons' => [
            'destroy' => 'Удалить',
        ],
        'modal' => [
            'title' => 'Вы уверены?',
            'button' => 'Я понимаю последствия, продолжить.',
        ],
    ],
    'installation' => [
        'message' => [
            'run_script' => 'Запустите следующую команду на своем сервере для запуска процесса установки необходимого ПО.',
            'waiting_response' => 'Ожидание ответа от сервера',
            'in_progress' => 'Установка...',
            'please_wait' => 'Процесс установки может занять несколько минут.',
        ],
    ],
    'php_versions' => [
        72 => 'PHP 7.2',
        73 => 'PHP 7.3',
        74 => 'PHP 7.4',
    ],
    'databases' => [
        'mysql' => 'MySQL 5.7',
        'mariadb' => 'MariaDB',
        'pgsql' => 'PostgreSQL',
        'mysql8' => 'MySQL 8',
    ],
    'web_servers' => [
        'nginx' => 'Nginx',
    ],
    'types' => [
        'webserver' => 'Web сервер',
        'openvpn' => 'OpenVPN серевер',
    ],
];
