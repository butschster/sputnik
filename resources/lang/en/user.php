<?php

return [
    'sidebar' => [
        'title' => 'Account',
        'profile' => 'Profile',
        'teams' => 'Teams',
    ],
    'header' => [
        'dropdown' => [
            'profile' => 'Profile',
            'teams' => 'Teams',
            'logout' => 'Log out',
        ],
    ],
    'profile' => [
        'title' => 'Profile',
        'member_since' => 'Member since',
        'deactivate' => [
            'title' => 'Destroy',
            'description' => 'This action can\'t be undone. Your profile and teams will be destroyed.',
            'button' => 'Destroy',
            'modal' => [
                'title' => 'Are you sure?',
                'description' => 'This action can\'t be undone. Your profile and teams will be destroyed.',
                'field' => ' Please, type your email address here for continue',
                'button' => 'I understand consequences, continue.',
            ],
        ],
        'edit_modal' => [
            'title' => 'Settings',
            'name' => 'Your name',
            'company' => 'Company',
            'lang' => 'Language',
            'save' => 'Update',
        ],
        'buttons' => [
            'edit' => 'Edit',
        ],
        'source_control' => [
            'title' => 'Source providers',
            'connected' => 'Connected',
            'available' => 'Available',
            'buttons' => [
                'refresh' => 'Refresh token',
                'unlink' => 'Unlink',
            ],
        ],
    ],
    'team' => [
        'list' => [
            'title' => 'Teams',
            'active' => 'Active teams',
        ],
        'title' => 'Team',
        'members' => [
            'title' => 'Members',
            'status' => [
                'owner' => 'Owner',
            ],
        ],
        'billing' => [
            'title' => 'Payment',
        ],
        'subscription' => [
            'title' => 'Subscription',
            'trial_ends_at' => 'Trial period ends at',
            'ends_at' => 'Subscription ends at',
            'available_plans' => 'Available plans',
            'cancel' => [
                'title' => 'Cancel subscription',
                'description' => 'You can reactivate your subscription at any time.',
                'button' => 'Cancel',
                'modal' => [
                    'title' => 'Are you sure?',
                    'description' => 'You can reactivate your subscription at any time.',
                    'buttons' => [
                        'yes' => 'Yes',
                        'no' => 'No',
                    ],
                ],
            ],
        ],
    ],
];
