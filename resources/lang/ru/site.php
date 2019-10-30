<?php

return [
    'section' => 'Сайты',
    'title' => 'Сайты',
    'form' => [
        'create' => [
            'title' => 'Новый сайт',
            'description' => 'Каждый сайт представляет собой конфигурацию виртуального хоста на сервере.',
            'label' => [
                'web_server' => 'Веб сервер',
                'processor' => 'Процессор',
                'domain' => 'Домен',
                'public_dir' => 'Публичная директория',
                'is_proxy' => 'Прокси',
                'proxy_address' => 'Проксируемый IP'
            ],
            'button' => [
                'create' => 'Создать',
            ],
            'message' => [
                'upgrade_subscription' => 'Обновите подписку для добавления большего кол-ва сайтов.',
            ],
        ],
    ],
];