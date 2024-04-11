<?php
return [
	'user' => [
		'admin' => [
			'creation' => [
				'username' => ['label' => '¿Qué nombre de usuario quieres usar?',
					'hint' => 'Teclea "exit" para finalizar la ejecución'], 'password' => '¿Y qué contraseña?',
				'language' => '¿Qué idioma te gustaría usar?',
				'existing' => 'El nombre de usuario ":username" ya existe en la plataforma.'],
			'update' => [
				'username' => ['label' => '¿Qué administrador quieres actualizar?',
					'hint' => 'Teclea "exit" para finalizar la ejecución'],
				'password' => '¿Cuál es la nueva contraseña?', 'language' => '¿Quieres actualizar el idioma? ¿A cuál?',
				'non_existing' => 'El nombre de usuario ":username" no pertenece a ningún administrador.',]]]];