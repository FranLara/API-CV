<?php

return [
    'creation' => [
        'admin' => [
            'username' => 'What username do you want to use? (Type "exit" to finish the command)',
            'password' => 'And which password for it?',
            'language' => 'Which language would you like to use? (Type the number of the desired one)' . PHP_EOL
                          . '  1.- English (default)' . PHP_EOL . '  2.- Castellano' . PHP_EOL . '  3.- Deutsch'
                          . PHP_EOL,
            'existing' => 'The username ":username" already exists in the platform.',
        ]
    ]
];