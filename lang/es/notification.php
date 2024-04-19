<?php

return [
    'regards' => 'Un saludo',
    'rights'  => 'Todos los derechos reservados.',
    'user'    => [
        'greeting'  => '¡Aviso!',
        'line_2'    => 'Su idioma escogido es el: ":language"',
        'admin'     => [
            'creation' => [
                'subject' => '¡Un nuevo administrador :username creado!',
                'line_1'  => 'La plataforma ha registrado un nuevo administrador: ":username"',
            ],
            'update'   => [
                'subject' => '¡Administrador :username actualizado!',
                'line_1'  => 'El administrador ":username" fue actualizado.',
            ]
        ],
        'recruiter' => [
            'creation' => [
                'subject' => '¡Un nuevo reclutador :email creado!',
                'line_1'  => 'La API ha registrado un nuevo reclutador: ":email"',
            ],
            'psswd'    => [
                'subject'  => '¡Usuario para la API del CV de Fran Lara creado!',
                'greeting' => 'Bienvenido/a',
                'line_1'   => 'Su usuario para llamar a la API del CV de Fran Lara ha sido creado. '
                              . 'Para llamar a los endpoints que requieren autenticación, necesitará obtener y usar un JWT. '
                              . 'Para solicitar un JWT, necesita llamar al siguiente endpoint con el usuario y contraseña dados:',
                'line_2'   => 'Endpoint: :endpoint',
                'line_3'   => 'Username: :username',
                'line_4'   => 'Passsword: :psswd',
                'line_5'   => 'No olvide añadir al header de la petición:',
                'line_6'   => '"Accept: application/:accept+json" y "Authorization: Bearer " y el JWT.',
                'line_7'   => 'Si tiene alguna pregunta, no dude en escribirme a :email'
            ]
        ]
    ]
];