<?php

namespace Tests\Unit\BusinessObjects\DTOs\Utils;

use App\BusinessObjects\DTOs\Utils\Token;
use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase
{
	private const ROLE = 'test_role';
	private const CREDENTIALS = ['test_credentials'];

	/**
	 * @dataProvider providerConstructorData
	 */
	public function testConstructor(Token $token, string $expectedRole = Token::GUEST_ROLE, array $expectedCredentials = []): void
	{
		$this->assertIsArray($token->getCredentials());
		$this->assertSame($expectedRole, $token->getRole());
		$this->assertSameSize($expectedCredentials, $token->getCredentials());
	}

	/**
	 * @dataProvider providerGetRole
	 */
	public function testGetRole(string $role = null, string $expectedRole = Token::GUEST_ROLE): void
	{
		$token = new Token();

		if (!is_null($role)) {
			$token = new Token($role);
		}
		$this->assertSame($expectedRole, $token->getRole());
	}

	/**
	 * @dataProvider providerGetCredentials
	 */
	public function testGetCredentials(array $credentials = null, array $expectedCredentials = []): void
	{
		$token = new Token(Token::GUEST_ROLE);

		if (!is_null($credentials)) {
			$token = new Token(Token::GUEST_ROLE, $credentials);
		}
		$this->assertSameSize($expectedCredentials, $token->getCredentials());
	}

	public static function providerConstructorData(): array
	{
		return [[new Token()], [new Token(self::ROLE), self::ROLE],
			[new Token(self::ROLE, self::CREDENTIALS), self::ROLE, self::CREDENTIALS]];
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
