<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',


    'provider' => [
        'github' => 'GitHub',
        'bitbucket' => 'Bitbucket',
        'message' => [
            'failed' => 'User not found.',
        ],
    ],

    'form' => [
        'login' => [
            'title' => 'Sigh In',
            'email' => 'E-mail address',
            'password' => 'Password',
            'remember_me' => 'Remember me',
            'sign_in_with_provider' => 'Or sign in by using',
            'no_account' => 'Don\'t have an account?',
            'button' => [
                'forgot_password' => 'Forgot password?',
                'login' => 'Sign In',
                'register' => 'Sign Up',
            ],
        ],
        'register' => [
            'title' => 'Sign Up',
            'project' => 'Project name',
            'name' => 'Your name',
            'email' => 'E-mail address',
            'password' => 'Password',
            'password_confirm' => 'Confirm',
            'sign_up_with_provider' => 'Or sign up by using',
            'have_account' => 'Do you have an account?',
            'button' => [
                'login' => 'Sign In',
                'register' => 'Sign Up',
            ],
        ],
        'reset_password_email' => [
            'title' => 'Reset password',
            'email' => 'E-mail address',
            'button' => [
                'reset' => 'Sent link to the email',
            ],
        ],
    ],
];
