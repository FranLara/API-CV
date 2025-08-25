<?php

declare(strict_types=1);

namespace Tests\Unit\Notifications\User\Admin;

use App\Notifications\User\Admin\Created;
use PHPUnit\Framework\Attributes\DataProvider;
use stdClass;

class CreatedTest extends AdminTests
{
    #[DataProvider('providerMailData')]
    public function testToMail(
        string $language,
        string $expectedSubject,
        string $expectedGreeting,
        string $expectedFirstLine,
        string $expectedSecondLine
    ): void {
        $mail = new Created($this->getAdmin($language))->toMail(new stdClass());

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
                'Admin ' . self::USERNAME . ' created!',
                'Warning!',
                'The system recorded a new Admin: "' . self::USERNAME . '"',
                'Their chosen language is: "English"',
            ],
            [
                'es',
                '¡Un nuevo administrador ' . self::USERNAME . ' creado!',
                '¡Aviso!',
                'La plataforma ha registrado un nuevo administrador: "' . self::USERNAME . '"',
                'Su idioma escogido es el: "Castellano"',
            ],
        ];
    }
}
