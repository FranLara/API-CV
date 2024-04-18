<?php
return ['regards' => 'Un saludo', 'rights' => 'Todos los derechos reservados.',
	'user' => ['greeting' => '¡Aviso!', 'line_2' => 'Su idioma escogido es el: ":language"',
		'admin' => [
			'creation' => ['subject' => '¡Un nuevo administrador :username creado!',
				'line_1' => 'La plataforma ha registrado un nuevo administrador: ":username"',],
			'update' => ['subject' => '¡Administrador :username actualizado!',
				'line_1' => 'El administrador ":username" fue actualizado.',]],
		'recruiter' => [
			'creation' => ['subject' => '¡Un nuevo reclutador :email creado!',
				'line_1' => 'La API ha registrado un nuevo reclutador: ":email"',],
			'psswd' => ['subject' => 'User for Fran Lara CV API created!', 'greeting' => 'Welcome',
				'line_1' => 'Your user to call the Fran Lara CV API has been created.',
				'line_2' => 'To make the calls to authenticated endpoints, you will need to request and use a JWT.',
				'line_3' => 'To request a JWT you need to call this endpoint :endpoint with the following credentials:',
				'line_4' => 'Username: :username', 'line_5' => 'Passsword: :psswd',
				'line_6' => 'Do not forget to add to request header "Authorization: Bearer " and the JWT.',
				'salutation' => 'If you have any doubt, do not hesitate to ask me writing to :email']]]];