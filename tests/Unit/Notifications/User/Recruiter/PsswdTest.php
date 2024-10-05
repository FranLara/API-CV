<?php
declare(strict_types = 1);

namespace Tests\Unit\Notifications\User\Recruiter;

use App\Notifications\User\Recruiter\Psswd;
use Illuminate\Support\Facades\Lang;
use stdClass;

class PsswdTest extends RecruiterTests
{
	/**
	 * @dataProvider providerMailData
	 */
	public function testToMail(string $language, string $expectedSubject, string $expectedGreeting, string $expectedFirstLine, string $expectedSecondLine, string $expectedThirdLine, string $expectedForthLine, string $expectedFifthLine, string $expectedSixthLine, string $expectedSeventhLine): void
	{
        Lang::setLocale($language);
		$mail = (new Psswd($this->getRecruiter($language)))->toMail(new stdClass());

		$this->assertSame($expectedSubject, $mail->subject);
		$this->assertSame($expectedGreeting, $mail->greeting);
		$this->assertSame($expectedFirstLine, $mail->introLines[0]);
		$this->assertSame($expectedThirdLine, $mail->introLines[2]);
		$this->assertSame($expectedForthLine, $mail->introLines[3]);
		$this->assertSame($expectedFifthLine, $mail->introLines[4]);
		$this->assertSame($expectedSixthLine, $mail->introLines[5]);
		$this->assertSame($expectedSecondLine, $mail->introLines[1]);
		$this->assertSame($expectedSeventhLine, $mail->introLines[6]);
	}

	public static function providerMailData(): array
	{
		return [
			['en', 'User for Fran Lara CV API created!', 'Welcome',
				'Your user to call the Fran Lara CV API has been created. ' .
				'To make the calls to authenticated endpoints, you will need to request and use a JWT. ' .
				'To request a JWT you need to call the following endpoint with the given credentials:',
				'Endpoint: https://domain.test/token?username=username&password=password', 'Username: ' . self::EMAIL,
				'Passsword: ' . self::PSSWD, 'Do not forget to add to the header of the request:',
				'"Accept: application/x.franlara.v1+json" and "Authorization: Bearer " and the JWT.',
				'If you have any doubt, do not hesitate to ask me writing to contact@notification.com'],
			['es', '¡Usuario para la API del CV de Fran Lara creado!', 'Bienvenido/a',
				'Su usuario para llamar a la API del CV de Fran Lara ha sido creado. ' .
				'Para llamar a los endpoints que requieren autenticación, necesitará obtener y usar un JWT. ' .
				'Para solicitar un JWT, necesita llamar al siguiente endpoint con el usuario y contraseña dados:',
				'Endpoint: https://domain.test/token?username=username&password=password', 'Username: ' . self::EMAIL,
				'Passsword: ' . self::PSSWD, 'No olvide añadir al header de la petición:',
				'"Accept: application/x.franlara.v1+json" y "Authorization: Bearer " y el JWT.',
				'Si tiene alguna pregunta, no dude en escribirme a contact@notification.com'],];
	}
}
