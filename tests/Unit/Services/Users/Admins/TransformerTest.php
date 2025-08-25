<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users\Admins;

use App\BusinessObjects\Models\Users\Admin as AdminModel;
use App\Services\Users\Admins\Transformer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\Utils\DTOs\SetGenerator;

class TransformerTest extends TestCase
{
    private const string USERNAME = 'test_username';
    private const string LANGUAGE = 'test_language';
    private const string IDENTIFIER = 'test_identifier';

    private const array VALUES = [self::USERNAME, self::LANGUAGE, self::IDENTIFIER];

    #[DataProvider('providerAdminData')]
    public function testTransform(?string $username = null, ?string $language = null, ?string $identifier = null): void
    {
        $admin = new Transformer()->transform($this->getModel($username, $language, $identifier));

        $this->assertSame($username, $admin->getUsername());
        $this->assertSame($language, $admin->getLanguage());
        $this->assertSame($identifier, $admin->getIdentifier());
    }

    public static function providerAdminData(): array
    {
        return array_merge(
            [self::VALUES],
            [[null, null, null]],
            SetGenerator::generate(self::VALUES, 1),
            SetGenerator::generate(self::VALUES, 2),
        );
    }

    private function getModel(?string $username, ?string $language, ?string $identifier): AdminModel
    {
        $admin = ['username' => $username, 'language' => $language, 'id' => $identifier];

        return new AdminModel($admin);
    }
}
