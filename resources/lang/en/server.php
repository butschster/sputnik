<?php

return [
    'modules' => [
        'title' => 'Modules',
        'available' => [
            'title' => 'Available modules',
            'description' => 'You can choose Software which will be installed on your server.',
        ],
        'selected' => [
            'title' => 'Selected modules',
            'description' => 'This modules will be installed on your server.',
        ],
        'installed' => [
            'title' => 'Installed',
        ],
        'button' => [
            'install' => 'Install',
        ],
        'message' => [
            'installed' => 'This modules will be installed soon. It will take a while.',
        ],
    ],
    'events' => [
        'title' => 'Events',
        'recent' => 'Recent events',
        'table' => [
            'event' => 'Event',
            'time' => 'Created at',
        ],
        'message' => [
            'empty_results' => 'Looks like you don\'t have any events yet.',
        ],
    ],
    'tasks' => [
        'title' => 'Tasks',
        'recent' => 'Recent scheduled',
        'table' => [
            'name' => 'Name',
            'status' => 'Status',
            'success' => 'Is succeed',
            'time' => 'Created at',
        ],
        'status' => [
            'new' => 'New',
            'pending' => 'Pending',
            'running' => 'In progress',
            'finished' => 'Success',
            'timeout' => 'Timeout',
        ],
        'message' => [
            'empty_results' => 'Looks like you don\'t have any scheduled tasks yet.',
        ],
        'item' => [
            'user' => 'User',
            'status' => 'Status',
            'success' => 'Success',
            'script' => 'Script',
            'output' => 'Output',
        ],
    ],
    'form' => [
        'create' => [
            'title' => 'Connect server',
            'description' => '
            You can connect any server with public IP. You server should have one of this OS [:os].',
            'label' => [
                'type' => 'Server type',
                'name' => 'Name',
                'team' => 'Team',
                'ip' => 'IP address',
                'ssh_port' => 'SSH port',
            ],
            'button' => [
                'create' => 'Connect',
            ],
            'message' => [
                'upgrade_subscription' => 'You have to upgrade your subscription to connect more servers.',
                'created' => 'Your server has been successfully connected.',
            ],
        ],
    ],
    'list' => [
        'title' => 'Active servers',
        'message' => [
            'empty' => 'Looks like you don\'t have any servers yet.',
        ],
    ],
    'sections' => [
        'title' => 'Server',
        'settings' => 'Settings',
        'modules' => 'Modules',
        'events' => 'Events',
        'tasks' => 'Tasks',
        'users' => 'Users',
        'supervisor' => 'Supervisor',
        'sites' => 'Sites',
    ],
    'settings' => [
        'title' => 'Settings',
        'system_information' => 'Information about system',
        'public_key' => [
            'title' => 'Public key',
            'description' => 'This public key will be automatically added on Github or Bitbucket if you connect them. You can add this key manually.',
        ],
        'metadata' => [
            'title' => 'Metadata',
            'form' => [
                'name' => 'Server name',
            ],
            'buttons' => [
                'save' => 'Update',
            ],
        ],
    ],
    'destroy' => [
        'title' => 'Delete server',
        'description' => 'This action can\'t be undone! All your information connected with this server will be destroyed, but all setting on your server will be kept.',
        'buttons' => [
            'destroy' => 'Delete',
        ],
        'modal' => [
            'title' => 'Are you sure?',
            'button' => 'I understand consequences, continue.',
        ],
    ],
    'installation' => [
        'message' => [
            'run_script' => 'You should run the following command on your server to initialize installation process.',
            'waiting_response' => 'Waiting for server response',
            'in_progress' => 'Installation in progress...',
            'please_wait' => 'Installation process may take a while.',
            'not_supported' => 'Sorry, your configuration [{{ info }}] is not supported!',
            'failed' => 'Installation process finished with error. Sorry we can\'t properly configure your server. Please delete in and try again.'
        ],
    ],
    'users' => [
        'title' => 'Users',
        'active' => 'Active users',
        'team' => 'Team',
        'table' => [
            'name' => 'Username',
            'password' => 'Password',
            'home' => 'Home dir',
            'status' => 'Status',
            'created_at' => 'Created at',
            'button' => [
                'download' => 'Download key',
                'delete' => 'Delete',
            ],
        ],
        'form' => [
            'create' => [
                'title' => 'Create user',
                'description' => 'When user will be created you can download key and use it for auth on the server.',
                'label' => [
                    'name' => 'Username',
                    'password' => 'Password',
                ],
                'button' => [
                    'create' => 'Create',
                ],
                'message' => [
                    'created' => 'User has been successfully created.',
                ],
            ],
        ],
        'message' => [
            'empty' => 'Looks like you don\'t have any users yet.',
        ],
    ],
    'alert' => [
        'type' => [
            'server-configure-failed' => 'Ошибка настройки сервера',
        ]
    ]
];
