<?php

return [
    'title' => 'Sites',
    'label' => [
        'expires_at' => 'Expires at',
    ],
    'section' => [
        'index' => 'Sites',
        'deployment' => 'Deployment',
        'environment' => 'Environment',
        'settings' => 'Settings',
    ],
    'form' => [
        'create' => [
            'title' => 'New site',
            'description' => 'Every site represents virtual host configuration on the server.',
            'label' => [
                'web_server' => 'Web server',
                'processor' => 'Processes handler',
                'domain' => 'Domain',
                'public_dir' => 'Public dir',
                'is_proxy' => 'Is proxy',
                'proxy_address' => 'Proxy IP',
            ],
            'button' => [
                'create' => 'Create',
            ],
            'message' => [
                'upgrade_subscription' => 'You should upgrade your subscription if you want to create more sites.',
            ],
        ],
    ],
    'settings' => [
        'title' => 'Settings',
        'environment' => [
            'empty' => 'Env variables aren\'t configured for this site.',
            'button' => [
                'configure' => 'Configure',
            ],
        ],
        'table' => [
            'domain' => 'Domain',
            'web_server' => 'Web server',
            'processor' => 'Processes handler',
            'path' => 'Site path',
            'public_path' => 'Public dir',
        ],
    ],
    'repository' => [
        'title' => 'Repository',
        'form' => [
            'label' => [
                'source_provider' => 'Source',
                'repository' => 'Repository name',
                'branch' => 'Branch',
            ],
            'button' => [
                'save' => 'Update',
            ],
        ],
    ],
    'public_key' => [
        'description' => 'Use this public key for deployment',
        'button' => [
            'register' => 'Add to the selected repository',
        ],
    ],
    'webhook' => [
        'title' => 'Deployment Trigger URL',
        'description' => 'Using a custom Git service, or want a service like Travis CI to run your tests before your 
        application is deployed? It\'s simple. When you commit fresh code, or when your continuous integration 
        service finishes testing your application, instruct the service to make a GET or POST request to the 
        following URL. Making a request to this URL will trigger your deployment script',
        'button' => [
            'register' => 'Add to the selected repository',
        ],
    ],
    'destroy' => [
        'title' => 'Destroy',
        'description' => 'This action can\'t be undone. All your settings connected with this site will be destroyed from your server.',
        'button' => [
            'destroy' => 'Destroy',
        ],
        'message' => [
            'successful' => 'Your site has been successfully destroyed',
        ],
        'modal' => [
            'title' => 'Are you sure?',
            'description' => 'This action can\'t be undone. Site\'s data will be completely destroyed.',
            'button' => [
                'destroy' => 'I understand consequences, continue.'
            ],
        ],
    ],
    'environment' => [
        'title' => 'Environment variables',
        'message' => [
            'empty' => 'Looks like you don\'t have any variables yet.',
        ],
        'form' => [
            'upload' => [
                'title' => 'Upload',
                'description' => 'Copy contents of .env file here.',
                'textarea' => 'String with variables',
                'button' => 'Upload',
            ],
            'create' => [
                'key' => 'Key',
                'value' => 'Value',
                'title' => 'Add variable',
                'button' => 'Add',
            ],
        ],
    ],
];