<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users\Admins;

use App\BusinessObjects\Models\Users\Admin;
use App\Services\Users\Admins\Transformer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\Utils\DTOs\SetGenerator;

class TransformerTest extends TestCase
{
    #[DataProvider('providerAdmin')]
    public function testTransform(Admin $model): void
    {
        $admin = new Transformer()->transform($model);

        $this->assertSame($model->id, $admin->getIdentifier());
        $this->assertSame($model->username, $admin->getUsername());
        $this->assertSame($model->language, $admin->getLanguage());
    }

    public static function providerAdmin(): array
    {
        $values = ['test_username', 'test_language', 'test_identifier'];

        $adminValues = array_merge(
            [$values],
            [[null, null, null]],
            SetGenerator::generate($values, 1),
            SetGenerator::generate($values, 2),
        );

        $tests = [];
        foreach ($adminValues as $values) {
            $tests[] = [new Admin(['username' => $values[0], 'language' => $values[1], 'id' => $values[2]])];
        }

        return $tests;
    }
}
