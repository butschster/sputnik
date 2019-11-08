<?php

return [
    'section' => 'Scheduler',
    'title' => 'Scheduler',
    'jobs' => 'Scheduled tasks',
    'table' => [
        'name' => 'Name',
        'cron' => 'Cron',
        'command' => 'Command',
        'user' => 'User',
        'next_run' => 'Next run at',
        'status' => 'Status',
    ],
    'form' => [
        'create' => [
            'title' => 'New task',
            'description' => 'You can easily schedule new tasks on your server.',
            'name' => 'Name',
            'command' => 'Command',
            'cron' => 'Cron string',
            'submit' => 'Schedule',
        ],
    ],
    'message' => [
        'empty_results' => 'Looks like you don\'t have any scheduled tasks yet.',
        'created' => 'Task has been successfully created.',
        'deleted' => 'Task has been successfully deleted.',
    ],
];
