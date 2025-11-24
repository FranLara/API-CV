<?php

return [
    'user' => [
        'admin' => [
            'creation' => [
                'username' => [
                    'label' => 'What username do you want to use?',
                    'hint'  => 'Type "exit" to finish the command',
                ],
                'password' => 'And which password for it?',
                'language' => 'Which language would you like to use?',
                'existing' => 'The username ":username" already exists in the platform.',
            ],
            'update'   => [
                'username'     => [
                    'label' => 'Which admin do you want to update?',
                    'hint'  => 'Type "exit" to finish the command',
                ],
                'password'     => 'Which is the new password?',
                'language'     => 'Do you want to update their language? To which one?',
                'non_existing' => 'The username ":username" doesn\'t belong to any admin.',
            ],
        ],
    ],
];
