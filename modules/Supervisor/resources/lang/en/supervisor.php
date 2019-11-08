<?php

return [
    'section' => 'Supervisor',
    'title' => 'Supervisor',
    'daemons' => 'Started daemons',
    'table' => [
        'command' => 'Command',
        'directory' => 'Dir',
        'procs' => 'Processes',
        'user' => 'User',
        'status' => 'Status',
    ],
    'form' => [
        'create' => [
            'title' => 'New daemon',
            'description' => 'Supervisor is a client/server system that allows its users to monitor and control a number of processes on UNIX-like operating systems.',
            'command' => 'Command',
            'user' => 'User',
            'procs' => 'Processes',
            'submit' => 'Start',
        ],
    ],
    'message' => [
        'empty_list' => 'Looks like you don\'t have any daemons yes',
        'created' => 'Daemon has been successfully created.',
        'deleted' => 'Daemon has been successfully deleted.',
    ],
];
