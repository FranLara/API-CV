<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users\Recruiters;

use App\BusinessObjects\Models\Users\Recruiter;
use App\Services\Users\Recruiters\Transformer;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Tests\Utils\DTOs\SetGenerator;

class TransformerTest extends TestCase
{
    #[DataProvider('providerRecruiter')]
    public function testTransform(Recruiter $model): void
    {
        $recruiter = new Transformer()->transform($model);

        $this->assertSame($model->name, $recruiter->getName());
        $this->assertSame($model->email, $recruiter->getEmail());
        $this->assertSame($model->id, $recruiter->getIdentifier());
        $this->assertSame($model->language, $recruiter->getLanguage());
        $this->assertSame($model->linkedin_profile, $recruiter->getLinkedinProfile());
    }

    public static function providerRecruiter(): array
    {
        $values = ['test_identifier', 'test_name', 'test_email', 'test_language', 'test_linkedin_profile'];

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
            $recruiter = [
                'id'               => $values[0],
                'name'             => $values[1],
                'email'            => $values[2],
                'language'         => $values[3],
                'linkedin_profile' => $values[4],
            ];
            $tests[] = [new Recruiter($recruiter)];
        }

        return $tests;
    }
}
