<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter as RecruiterDTO;
use App\BusinessObjects\Models\Users\Recruiter;
use App\Services\Users\Recruiters\Mapper;
use App\Services\Users\Recruiters\Saver;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\Exception;
use Tests\Unit\Services\Users\UserTests;

class SaverTest extends UserTests
{
    private const string NAME = 'test_name';
    private const string EMAIL = 'test_email';
    private const string PSSWD = 'test_psswd';
    private const string LANGUAGE = 'test_language';
    private const string LINKEDIN_PROFILE = 'https://test_linkedin_profile.test';

    /**
     * @throws Exception
     */
    #[DataProvider('providerUser')]
    public function testSave(bool $existing, bool $modified = false): void
    {
        $mapper = $this->createConfiguredMock(Mapper::class, ['map' => $this->getRecruiter($existing, $modified)]);
        new Saver($mapper)->save(new RecruiterDTO());
        $recruiter = Recruiter::whereEmail(self::EMAIL)->first();

        $this->assertSame(self::EMAIL, $recruiter->email);
        $this->assertSame($this->getExpectedField(self::NAME, $modified), $recruiter->name);
        $this->assertSame($this->getExpectedField(self::LANGUAGE, $modified), $recruiter->language);
        $this->assertTrue(Hash::check($this->getExpectedField(self::PSSWD, $modified), $recruiter->password));
        $this->assertSame($this->getExpectedField(self::LINKEDIN_PROFILE, $modified), $recruiter->linkedin_profile);
    }

    public static function providerUser(): array
    {
        return [[false], [true], [true, true]];
    }

    private function getRecruiter(bool $existing, bool $modified): Recruiter
    {
        $default = [
            'email'            => self::EMAIL,
            'name'             => self::NAME,
            'language'         => self::LANGUAGE,
            'linkedin_profile' => self::LINKEDIN_PROFILE,
            'password'         => Hash::make(self::PSSWD),
        ];
        $recruiter = new Recruiter($default);

        if ($existing) {
            $recruiter = Recruiter::factory()->create($default);
        }
        if ($modified) {
            $recruiter->name = self::NAME . '_mod';
            $recruiter->language = self::LANGUAGE . '_mod';
            $recruiter->password = Hash::make(self::PSSWD . '_mod');
            $recruiter->linkedin_profile = self::LINKEDIN_PROFILE . '_mod';
        }

        return $recruiter;
    }
}
