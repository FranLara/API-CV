<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users\Technicians;

use App\BusinessObjects\DTOs\Users\Technician as TechnicianDTO;
use App\BusinessObjects\Models\Users\Technician;
use App\Services\Users\Technicians\Mapper;
use App\Services\Users\Technicians\Saver;
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
    private const string GITHUB_PROFILE = 'https://test_github_profile.test';
    private const string LINKEDIN_PROFILE = 'https://test_linkedin_profile.test';

    /**
     * @throws Exception
     */
    #[DataProvider('providerUser')]
    public function testSave(bool $existing, bool $modified = false): void
    {
        $mapper = $this->createConfiguredMock(Mapper::class, ['map' => $this->getTechnician($existing, $modified)]);
        new Saver($mapper)->save(new TechnicianDTO());
        $technician = Technician::whereEmail(self::EMAIL)->first();

        $this->assertSame(self::EMAIL, $technician->email);
        $this->assertSame($this->getExpectedField(self::NAME, $modified), $technician->name);
        $this->assertSame($this->getExpectedField(self::LANGUAGE, $modified), $technician->language);
        $this->assertTrue(Hash::check($this->getExpectedField(self::PSSWD, $modified), $technician->password));
        $this->assertSame($this->getExpectedField(self::GITHUB_PROFILE, $modified), $technician->github_profile);
        $this->assertSame($this->getExpectedField(self::LINKEDIN_PROFILE, $modified), $technician->linkedin_profile);
    }

    public static function providerUser(): array
    {
        return [[false], [true], [true, true]];
    }

    private function getTechnician(bool $existing, bool $modified): Technician
    {
        $default = [
            'email'            => self::EMAIL,
            'name'             => self::NAME,
            'language'         => self::LANGUAGE,
            'github_profile'   => self::GITHUB_PROFILE,
            'linkedin_profile' => self::LINKEDIN_PROFILE,
            'password'         => Hash::make(self::PSSWD),
        ];
        $technician = new Technician($default);

        if ($existing) {
            $technician = Technician::factory()->create($default);
        }
        if ($modified) {
            $technician->name = self::NAME . '_mod';
            $technician->language = self::LANGUAGE . '_mod';
            $technician->password = Hash::make(self::PSSWD . '_mod');
            $technician->github_profile = self::GITHUB_PROFILE . '_mod';
            $technician->linkedin_profile = self::LINKEDIN_PROFILE . '_mod';
        }

        return $technician;
    }
}
