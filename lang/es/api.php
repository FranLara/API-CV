<?php

return [
    'endpoints' => [
        'tokens'   => [
            'request' => 'Devuelve un JSON Web Token (JWT) basado en el username/password enviado en la petición.',
            'refresh' => 'Devuelve un JSON Web Token (JWT) con el tiempo de expiración actualizado.',
        ],
        'accounts' => ['request' => 'Solicita la creación de una cuenta de usuario.'],
    ],
];
