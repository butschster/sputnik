<?php

return [
    'clients' => [
        'section' => 'OpenVPN clients',
        'title' => 'OpenVPN clients',
        'clients' => 'Clients',
        'table' => [
            'name' => 'Name',
            'status' => 'Status',
            'time' => 'Created at',
        ],
        'form' => [
            'create' => [
                'title' => 'Create new client',
                'label' => [
                    'name' => 'Name',
                ],
                'button' => [
                    'create' => 'Create',
                ],
            ],
        ],
        'message' => [
            'empty_results' => 'Looks like you don\'t have any clients yet.',
            'created' => 'Client has been successfully created.',
            'deleted' => 'Client has been successfully deleted.',
        ],
    ]
];