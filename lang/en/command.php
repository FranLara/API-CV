<?php

return [
    'user' => [
        'admin' => [
            'creation' => [
                'username' => 'What username do you want to use? (Type "exit" to finish the command)',
                'password' => 'And which password for it?',
                'language' => 'Which language would you like to use? (Type the number of the desired one)' . PHP_EOL
                              . '  1.- English (default)' . PHP_EOL . '  2.- Castellano' . PHP_EOL . '  3.- Deutsch'
                              . PHP_EOL,
                'existing' => 'The username ":username" already exists in the platform.',
            ],
            'update'   => [
                'username'     => 'Which admin do you want to update? (Type "exit" to finish the command)',
                'password'     => 'Which is the new password?',
                'language'     => '¿Quieres actualizar el idioma? ¿A cuál? (Teclea el número del deseado)' . PHP_EOL
                                  . PHP_EOL . 'AVISO: El actual es el indicado entre corchetes' . PHP_EOL
                                  . '  1.- English' . PHP_EOL . '  2.- Castellano' . PHP_EOL . '  3.- Deutsch'
                                  . PHP_EOL,
                'non_existing' => 'El nombre de usuario ":username" no pertenece a ningún administrador.',
            ]
        ]
    ],
];