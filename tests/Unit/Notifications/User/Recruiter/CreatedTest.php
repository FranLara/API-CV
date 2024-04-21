<?php
declare(strict_types = 1);

namespace Tests\Unit\Notifications\User\Recruiter;

use App\Notifications\User\Recruiter\Created;
use stdClass;

class CreatedTest extends RecruiterTest
{

	/**
	 * @dataProvider providerMailData
	 */
	public function testToMail(string $language, string $expectedSubject, string $expectedGreeting, string $expectedFirstLine, string $expectedSecondLine): void
	{
		$mail = (new Created($this->getRecruiter($language)))->toMail(new stdClass());

		$this->assertSame($expectedSubject, $mail->subject);
		$this->assertSame($expectedGreeting, $mail->greeting);
		$this->assertSame($expectedFirstLine, $mail->introLines[0]);
		$this->assertSame($expectedSecondLine, $mail->introLines[1]);
	}

	public static function providerMailData(): array
	{
		return [
			['en', 'Recruiter ' . self::EMAIL . ' created!', 'Warning!',
				'The API recorded a new Recruiter "' . self::EMAIL .
				'" with this LinkedIn profile "test_linkedin_profile.com"', 'Their chosen language is: "English"'],
			['es', '¡Un nuevo reclutador ' . self::EMAIL . ' creado!', '¡Aviso!',
				'La API ha registrado un nuevo reclutador "' . self::EMAIL .
				'" con este perfil de LinkedIn "test_linkedin_profile.com"', 'Su idioma escogido es el: "Castellano"'],];
	}
}
