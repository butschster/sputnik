<?php

return [
    [
        'type' => 'github',
        'name' => 'Github',
        'icon' => 'fa-github',
        'scopes' => ['repo', 'user:email', 'write:public_key', 'read:public_key', 'admin:repo_hook'],
    ],
    [
        'type' => 'bitbucket',
        'name' => 'Bitbucket',
        'icon' => 'fa-bitbucket',
        'scopes' => [],
    ],
];