<?php

return [
    'title' => 'Сайты',
    'label' => [
        'expires_at' => 'Истекает',
    ],
    'section' => [
        'index' => 'Сайты',
        'deployment' => 'Deployment',
        'environment' => 'Окружение',
        'settings' => 'Настройки',
    ],
    'form' => [
        'create' => [
            'title' => 'Новый сайт',
            'description' => 'Каждый сайт представляет собой конфигурацию виртуального хоста на сервере.',
            'label' => [
                'web_server' => 'Веб сервер',
                'processor' => 'Обработчик запросов',
                'domain' => 'Домен',
                'public_dir' => 'Публичная директория',
                'is_proxy' => 'Прокси',
                'proxy_address' => 'Проксируемый IP',
            ],
            'button' => [
                'create' => 'Создать',
            ],
            'message' => [
                'upgrade_subscription' => 'Обновите подписку для добавления большего кол-ва сайтов.',
            ],
        ],
    ],
    'settings' => [
        'title' => 'Настройки',
        'environment' => [
            'empty' => 'Для сайта не настроены ENV переменные',
            'button' => [
                'configure' => 'Настроить',
            ],
        ],
        'table' => [
            'domain' => 'Основной домен',
            'web_server' => 'Веб сервер',
            'processor' => 'Обработчик запросов',
            'path' => 'Путь до файлов',
            'public_path' => 'Публичная директория',
        ],
    ],
    'repository' => [
        'title' => 'Репозиторий',
        'form' => [
            'label' => [
                'source_provider' => 'Источник',
                'repository' => 'Название репозитория',
                'branch' => 'Ветка',
            ],
            'button' => [
                'save' => 'Сохранить',
            ],
        ],
    ],
    'public_key' => [
        'description' => 'Используйте этот публичный ключ для deployment',
        'button' => [
            'register' => 'Добавить в репозиторий',
        ],
    ],
    'webhook' => [
        'title' => 'Deployment Trigger URL',
        'description' => 'Using a custom Git service, or want a service like Travis CI to run your tests before your 
        application is deployed? It\'s simple. When you commit fresh code, or when your continuous integration 
        service finishes testing your application, instruct the service to make a GET or POST request to the 
        following URL. Making a request to this URL will trigger your deployment script',
        'button' => [
            'register' => 'Добавить в репозиторий',
        ],
    ],
    'destroy' => [
        'title' => 'Удалить сайт',
        'description' => 'Данное действие не может быть отменено. При удалении сайта будет удалена директория с файлами и конфигурацией для сайта с вашего сервера.',
        'button' => [
            'destroy' => 'Удалить',
        ],
        'message' => [
            'successful' => 'Сайт успешно удален',
        ],
        'modal' => [
            'title' => 'Вы уверены?',
            'description' => 'Данное действие не может быть отменено. Сайт будет окончательно удален.',
            'button' => [
                'destroy' => 'Я понимаю последствия, продолжить',
            ],
        ],
    ],
    'environment' => [
        'title' => 'Переменные окружения',
        'message' => [
            'empty' => 'Похоже вы не добавили ни одной переменной.',
        ],
        'form' => [
            'upload' => [
                'title' => 'Загрузить из файла',
                'description' => 'Скопируйте содержимое .env файла.',
                'textarea' => 'Строка с переменными',
                'button' => 'Загрузить',
            ],
            'create' => [
                'key' => 'Ключ',
                'value' => 'Значение',
                'title' => 'Добавить пемененную',
                'button' => 'Добавить',
            ],
        ],
    ],
];