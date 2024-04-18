<?php
return ['regards' => 'Regards', 'rights' => 'All rights reserved.',
	'user' => ['greeting' => 'Warning!', 'line_2' => 'Their chosen language is: ":language"',
		'admin' => [
			'creation' => ['subject' => 'Admin :username created!',
				'line_1' => 'The system recorded a new Admin: ":username"',],
			'update' => ['subject' => 'Admin :username updated!', 'line_1' => 'The admin ":username" was updated.',]],
		'recruiter' => [
			'creation' => ['subject' => 'Recruiter :email created!',
				'line_1' => 'The API recorded a new Recruiter: ":email"',],
			'psswd' => ['subject' => 'User for Fran Lara CV API created!', 'greeting' => 'Welcome',
				'line_1' => 'Your user to call the Fran Lara CV API has been created.',
				'line_2' => 'To make the calls to the authenticated endpoints you will need to get and use a JWT.',
				'line_3' => 'To request a JWT you will need to call to this endpoint :endpoint with the following credentials:',
				'line_4' => 'Username: :username', 'line_5' => 'Passsword: :psswd',],]]];