<?php

namespace Unit\Notifications\User\Admin;

use App\BusinessObjects\DTOs\Users\Admin;
use App\Notifications\User\Admin\Updated;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;
use stdClass;

class UpdatedTest extends TestCase
{

	/**
	 * @dataProvider providerMailData
	 */
	public function testToMail(string $language, string $expectedSubject, string $expectedGreeting, string $expectedFirstLine, string $expectedSecondLine): void
	{
		$admin = new Admin('test_username', $language);
		Lang::setLocale($admin->getLanguage());

		$mail = (new Updated($admin))->toMail(new stdClass());

		$this->assertSame($expectedSubject, $mail->subject);
		$this->assertSame($expectedGreeting, $mail->greeting);
		$this->assertSame($expectedFirstLine, $mail->introLines[0]);
		$this->assertSame($expectedSecondLine, $mail->introLines[1]);
	}

	public static function providerMailData(): array
	{
		return [
			['en', 'Admin test_username updated!', 'Warning!', 'The admin "test_username" was updated.',
				'Their chosen language is: "English"'],
			['es', '¡Administrador test_username actualizado!', '¡Aviso!',
				'El administrador "test_username" fue actualizado.', 'Su idioma escogido es el: "Castellano"'],];
	}
}
