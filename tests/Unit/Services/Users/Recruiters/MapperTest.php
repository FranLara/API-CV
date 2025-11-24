<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter as RecruiterDTO;
use App\BusinessObjects\Models\Users\Recruiter;
use App\Services\Users\Recruiters\Mapper;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use Tests\Utils\DTOs\SetGenerator;
use Tests\Utils\Services\Users\Mapper as MapperUtils;

class MapperTest extends TestCase
{
    use MapperUtils;

    #[DataProvider('providerRecruiter')]
    public function testMap(RecruiterDTO $dto): void
    {
        $recruiter = new Mapper()->map($dto, new Recruiter());

        $this->assertSame($dto->getName(), $recruiter->name);
        $this->assertSame($dto->getLanguage(), $recruiter->language);
        $this->assertSame($dto->getLinkedinProfile(), $recruiter->linkedin_profile);
        if (!empty($dto->getPsswd())) {
            $this->assertTrue(Hash::check($dto->getPsswd(), $recruiter->password));
        }
        if (empty($dto->getIdentifier())) {
            $this->assertGreaterThan(now()->subMinute(), $recruiter->created_at);
        }
    }

    public static function providerRecruiter(): array
    {
        $values = [self::NAME, self::PSSWD, self::LANGUAGE, self::IDENTIFIER, self::LINKEDIN_PROFILE];

        $recruiterValues = array_merge(
            [$values],
            [[null, null, null, null, null]],
            SetGenerator::generate($values, 1),
            SetGenerator::generate($values, 2),
            SetGenerator::generate($values, 3),
            SetGenerator::generate($values, 4),
        );

        $tests = [];
        foreach ($recruiterValues as $values) {
            $recruiter = new RecruiterDTO(
                name: $values[0],
                psswd: $values[1],
                language: $values[2],
                identifier: $values[3],
                linkedinProfile: $values[4]
            );
            $tests[] = [$recruiter];
        }

        return $tests;
    }
}
