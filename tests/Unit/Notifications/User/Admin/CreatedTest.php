<?php

namespace Unit\Notifications\User\Admin;

use App\BusinessObjects\DTOs\Users\Admin;
use App\Notifications\User\Admin\Created;
use Illuminate\Support\Facades\Lang;
use stdClass;
use Tests\TestCase;

class CreatedTest extends TestCase
{
    /**
     * @dataProvider providerMailData
     */
    public function testToMail(
        string $language,
        string $expectedSubject,
        string $expectedGreeting,
        string $expectedFirstLine,
        string $expectedSecondLine
    ): void {
        $admin = new Admin('test_username', $language);
        Lang::setLocale($admin->getLanguage());

        $mail = (new Created($admin))->toMail(new stdClass());

        $this->assertSame($expectedSubject, $mail->subject);
        $this->assertSame($expectedGreeting, $mail->greeting);
        $this->assertSame($expectedFirstLine, $mail->introLines[0]);
        $this->assertSame($expectedSecondLine, $mail->introLines[1]);
    }

    public static function providerMailData(): array
    {
        return [
            [
                'en',
                'Admin test_username created!',
                'Warning!',
                'The system recorded a new Admin: "test_username"',
                'Their chosen language is: "English"'
            ],
            [
                'es',
                '¡Un nuevo administrador test_username creado!',
                '¡Aviso!',
                'La plataforma ha registrado un nuevo administrador: "test_username"',
                'Su idioma escogido es el: "Castellano"'
            ],
        ];
    }
}
