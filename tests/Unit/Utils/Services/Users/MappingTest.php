<?php

declare(strict_types=1);

namespace Tests\Unit\Utils\Services\Users;

use App\BusinessObjects\DTOs\Users\Recruiter as RecruiterDTO;
use App\BusinessObjects\DTOs\Users\Technician as TechnicianDTO;
use App\BusinessObjects\DTOs\Users\User as UserDTO;
use App\BusinessObjects\Models\Users\Recruiter;
use App\BusinessObjects\Models\Users\Technician;
use App\BusinessObjects\Models\Users\User;
use App\Utils\Services\Users\Mapping as MappingUtil;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use ReflectionClass;
use ReflectionException;
use Tests\TestCase;
use Tests\Utils\DTOs\SetGenerator;
use Tests\Utils\Services\Users\Mapper as MapperUtils;

class MappingTest extends TestCase
{
    use MapperUtils;

    /**
     * @throws ReflectionException
     */
    #[DataProvider('providerUsers')]
    public function testMapUserNotEmptyValues(UserDTO $dto, User $user): void
    {
        $mapping = new class() {
            use MappingUtil;
        };

        $class = new ReflectionClass(get_class($mapping));
        $method = $class->getMethod('mapUserNotEmptyValues');
        $method->setAccessible(true);

        $user = $method->invokeArgs($mapping, [$user, $dto]);

        $this->assertSame($dto->getName(), $user->name);
        $this->assertSame($dto->getLanguage(), $user->language);
        $this->assertSame($dto->getLinkedinProfile(), $user->linkedin_profile);
        if (!empty($dto->getPsswd())) {
            $this->assertTrue(Hash::check($dto->getPsswd(), $user->password));
        }
    }

    public static function providerUsers(): array
    {
        $values = [self::NAME, self::PSSWD, self::LANGUAGE, self::LINKEDIN_PROFILE];

        $userValues = array_merge(
            [$values],
            [[null, null, null, null]],
            SetGenerator::generate($values, 1),
            SetGenerator::generate($values, 2),
            SetGenerator::generate($values, 3),
        );

        $tests = [];
        foreach ($userValues as $values) {
            $tests[] = [self::getUserDTO(RecruiterDTO::class, $values), new Recruiter()];
            $tests[] = [self::getUserDTO(TechnicianDTO::class, $values), new Technician()];
        }

        return $tests;
    }

    private static function getUserDTO(string $user, array $values): UserDTO
    {
        return new $user(name: $values[0], psswd: $values[1], language: $values[2], linkedinProfile: $values[3]);
    }
}
