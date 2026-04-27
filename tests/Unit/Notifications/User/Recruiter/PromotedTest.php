<?php

declare(strict_types=1);

namespace Tests\Unit\Notifications\User\Recruiter;

use App\Notifications\User\Recruiter\Promoted;
use Illuminate\Support\Facades\Lang;
use PHPUnit\Framework\Attributes\DataProvider;
use stdClass;

class PromotedTest extends RecruiterTests
{
    #[DataProvider('providerMailData')]
    public function testToMail(string $language, array $expectedMessages): void
    {
        Lang::setLocale($language);
        $mail = new Promoted($this->getFullRecruiter($language))->toMail(new stdClass());

        $this->assertSame($expectedMessages[0], $mail->subject);
        $this->assertSame($expectedMessages[1], $mail->greeting);
        $this->assertSame($expectedMessages[2], $mail->introLines[0]);
        $this->assertSame($expectedMessages[3], $mail->introLines[1]);
        $this->assertSame($expectedMessages[4], $mail->introLines[2]);
        $this->assertSame($expectedMessages[5], $mail->introLines[3]);
    }

    public static function providerMailData(): array
    {
        return [
            [
                'en',
                [
                    'Your user was promoted in the Fran Lara CV API!',
                    'Hello',
                    'Your user ' . self::EMAIL . ' was internally promoted to a new role in the application.',
                    'Add your GitHub account calling the following endpoint to access the API source code:',
                    'Endpoint (PATCH): https://domain.test/accounts',
                    'Payload: {"github_profile":"your_github_profile"}',
                ],
            ],
            [
                'es',
                [
                    '¡Su usuario ha sido promocionado en la API del CV de Fran Lara!',
                    'Hola',
                    'Su usuario ' . self::EMAIL . ' fue internamente promocionado a un nuevo rol en la aplicación.',
                    'Para acceder al código fuente de la API, añada su perfil de GitHub '
                    . 'llamando al siguiente endpoint:',
                    'Endpoint (PATCH): https://domain.test/accounts',
                    'Payload: {"github_profile":"tu_perfil_de_github"}',
                ],
            ],
        ];
    }
}
