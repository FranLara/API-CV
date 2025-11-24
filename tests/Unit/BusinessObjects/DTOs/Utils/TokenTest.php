<?php

declare(strict_types=1);

namespace Tests\Unit\BusinessObjects\DTOs\Utils;

use App\BusinessObjects\DTOs\Utils\Token;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase
{
    private const string ROLE = 'test_role';
    private const array CREDENTIALS = ['test_credentials'];

    #[DataProvider('providerConstructorData')]
    public function testConstructor(
        Token $token,
        string $expectedRole = Token::GUEST_ROLE,
        array $expectedCredentials = []
    ): void {
        $this->assertSame($expectedRole, $token->getRole());
        $this->assertSameSize($expectedCredentials, $token->getCredentials());
    }

    #[DataProvider('providerGetRole')]
    public function testGetRole(?string $role = null, string $expectedRole = Token::GUEST_ROLE): void
    {
        $token = new Token();

        if (!is_null($role)) {
            $token = new Token($role);
        }
        $this->assertSame($expectedRole, $token->getRole());
    }
    
    #[DataProvider('providerGetCredentials')]
    public function testGetCredentials(?array $credentials = null, array $expectedCredentials = []): void
    {
        $token = new Token(Token::GUEST_ROLE);

        if (!is_null($credentials)) {
            $token = new Token(Token::GUEST_ROLE, $credentials);
        }
        $this->assertSameSize($expectedCredentials, $token->getCredentials());
    }

    public static function providerConstructorData(): array
    {
        return [
            [new Token()],
            [new Token(self::ROLE), self::ROLE],
            [new Token(self::ROLE, self::CREDENTIALS), self::ROLE, self::CREDENTIALS],
        ];
    }

    public static function providerGetRole(): array
    {
        return [[], [self::ROLE, self::ROLE]];
    }

    public static function providerGetCredentials(): array
    {
        return [[], [self::CREDENTIALS, self::CREDENTIALS]];
    }
}
