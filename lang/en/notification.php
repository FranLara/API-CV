<?php

return [
    'regards' => 'Regards',
    'rights'  => 'All rights reserved.',
    'user'    => [
        'greeting'  => 'Warning!',
        'line_2'    => 'Their chosen language is: ":language"',
        'admin'     => [
            'creation' => [
                'subject' => 'Admin :username created!',
                'line_1'  => 'The system recorded a new Admin: ":username"',
            ],
            'update'   => ['subject' => 'Admin :username updated!', 'line_1' => 'The admin ":username" was updated.'],
        ],
        'recruiter' => [
            'creation' => [
                'subject' => 'Recruiter :email created!',
                'line_1'  => 'The API recorded a new Recruiter ":email" with this LinkedIn profile ":linkedin_profile"',
            ],
            'psswd'    => [
                'subject'  => 'User for Fran Lara CV API created!',
                'greeting' => 'Welcome',
                'line_1'   => 'Your user to call the Fran Lara CV API has been created. '
                              . 'To make the calls to authenticated endpoints, you will need to request and use a JWT. '
                              . 'To request a JWT you need to call the following endpoint with the given credentials:',
                'line_2'   => 'Endpoint: :endpoint',
                'line_3'   => 'Username: :username',
                'line_4'   => 'Passsword: :psswd',
                'line_5'   => 'Do not forget to add to the header of the request:',
                'line_6'   => '"Accept: application/:accept+json" and "Authorization: Bearer " and the JWT.',
                'line_7'   => 'If you have any doubt, do not hesitate to ask me writing to :email',
            ],
        ],
    ],
];