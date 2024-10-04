<?php

declare(strict_types=1);

namespace Tests\Unit\Notifications\User\Admin;

use App\Notifications\User\Admin\Updated;
use stdClass;

class UpdatedTest extends AdminTests
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
        $mail = (new Updated($this->getAdmin($language)))->toMail(new stdClass());

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
                'Admin ' . self::USERNAME . ' updated!',
                'Warning!',
                'The admin "' . self::USERNAME . '" was updated.',
                'Their chosen language is: "English"'
            ],
            [
                'es',
                '¡Administrador ' . self::USERNAME . ' actualizado!',
                '¡Aviso!',
                'El administrador "' . self::USERNAME . '" fue actualizado.',
                'Su idioma escogido es el: "Castellano"'
            ],
        ];
    }
}
