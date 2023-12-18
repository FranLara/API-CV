<?php

return [
    'user' => [
        'admin' => [
            'creation' => [
                'username' => '¿Qué nombre de usuario quieres usar? (Teclea "exit" para finalizar la ejecución)',
                'password' => '¿Y qué contraseña?',
                'language' => '¿Qué idioma te gustaría usar? (Teclea el número del deseado)' . PHP_EOL
                              . '  1.- English (default)' . PHP_EOL . '  2.- Castellano' . PHP_EOL . '  3.- Deutsch'
                              . PHP_EOL,
                'existing' => 'El nombre de usuario ":username" ya existe en la plataforma.',
            ],
            'update'   => [
                'username'     => '¿Qué administrador quieres actualizar? (Teclea "exit" para finalizar la ejecución)',
                'password'     => '¿Cuál es la nueva contraseña?',
                'language'     => '¿Quieres actualizar el idioma? ¿A cuál? (Teclea el número del deseado)'
                                  . PHP_EOL . 'AVISO: El actual es el indicado entre corchetes' . PHP_EOL
                                  . '  1.- English' . PHP_EOL . '  2.- Castellano' . PHP_EOL . '  3.- Deutsch'
                                  . PHP_EOL,
                'non_existing' => 'El nombre de usuario ":username" no pertenece a ningún administrador.',
            ]
        ]
    ]
];