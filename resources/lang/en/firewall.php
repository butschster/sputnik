<?php

return [
    'section' => 'Firewall',
    'title' => 'Firewall',
    'active_rules' => 'Active rules',
    'table' => [
        'name' => 'Name',
        'port' => 'Port',
        'from' => 'From',
        'policy' => 'Policy',
        'status' => 'Status',
    ],
    'message' => [
        'empty_rules' => 'You don\'t have any rules yet.',
        'created' => 'New rule has been successfully created!',
        'deleted' => 'The rule has been successfully deleted.',
    ],
    'form' => [
        'create' => [
            'title' => 'Add a new rule',
            'label' => [
                'name' => 'Name',
                'port' => 'Port',
                'from' => 'From',
                'policy' => 'Policy',
            ],
            'button' => [
                'create' => 'Create',
            ],
        ],
    ],
];