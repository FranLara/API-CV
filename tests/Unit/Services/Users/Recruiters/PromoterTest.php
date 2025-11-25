<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\BusinessObjects\Models\Users\Recruiter as RecruiterModel;
use App\BusinessObjects\Models\Users\Technician;
use App\BusinessObjects\Models\Users\Technician as TechnicianModel;
use App\Exceptions\Services\Users\Recruiters\InvalidPromotionException;
use App\Exceptions\Services\Users\Recruiters\PromotionException;
use App\Exceptions\Services\Users\UserNotFoundException;
use App\Services\Retriever;
use App\Services\Saver;
use App\Services\Users\Recruiters\Promoter;
use App\Services\Users\Recruiters\Transformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\MockObject\Exception;
use Tests\Unit\Services\ServiceTests;
use Tests\Utils\Recruiter as RecruiterUtils;

class PromoterTest extends ServiceTests
{
    use RecruiterUtils;

    /**
     * @throws InvalidPromotionException
     * @throws UserNotFoundException
     * @throws PromotionException
     * @throws Exception
     */
    public function testPromote(): void
    {
        $recruiter = $this->getRecruiterPromotion();
        $this->getPromoter($this->getRetriever($recruiter))->promote($recruiter->getEmail());

        $technician = TechnicianModel::whereEmail($recruiter->getEmail())->first();

        $this->assertDatabaseCount('jobs', 1);
        $this->assertDatabaseCount('recruiters', 0);
        $this->assertDatabaseCount('technicians', 1);
        $this->assertDatabaseHas('jobs', ['queue' => 'listeners']);
        $this->assertTrue(Hash::check(self::PSSWD, $technician->password));
    }

    /**
     * @throws Exception
     * @throws InvalidPromotionException
     * @throws PromotionException
     * @throws UserNotFoundException
     */
    public function testPromoteUserNotFoundException(): void
    {
        $this->expectException(UserNotFoundException::class);

        $this->getPromoter($this->getRetriever())->promote(fake()->email);
    }

    /**
     * @throws Exception
     * @throws UserNotFoundException
     * @throws PromotionException
     */
    public function testPromoteInvalidPromotionException(): void
    {
        $this->expectException(InvalidPromotionException::class);

        $recruiter = $this->getRecruiterWithoutPsswd();
        $recruiter->setLinkedinProfile(null);

        $this->getPromoter($this->getRetriever($recruiter))->promote($recruiter->getEmail());
    }

    /**
     * @throws InvalidPromotionException
     * @throws UserNotFoundException
     * @throws Exception
     */
    public function testPromotePromotionException(): void
    {
        $this->expectException(PromotionException::class);

        $recruiter = $this->getRecruiterWithoutPsswd();
        $this->getPromoter($this->getRetriever($recruiter), false)->promote($recruiter->getEmail());
    }

    private function getRecruiterPromotion(): Recruiter
    {
        $recruiter = RecruiterModel::factory()->create(['password' => Hash::make(self::PSSWD)]);

        $technician = [
            'name'             => $recruiter->name,
            'email'            => $recruiter->email,
            'language'         => $recruiter->language,
            'linkedin_profile' => $recruiter->linkedin_profile,
        ];
        Technician::factory()->create($technician);
        DB::table('jobs')->truncate();

        return new Transformer()->transform($recruiter);
    }

    /**
     * @throws Exception
     */
    private function getRetriever(?Recruiter $recruiter = null): Retriever
    {
        $retriever = $this->createMock(Retriever::class);

        if (empty($recruiter)) {
            $retriever->method('retrieveByField')->willThrowException(new ModelNotFoundException());

            return $retriever;
        }

        $retriever->method('retrieveByField')->willReturn($recruiter);

        return $retriever;
    }

    /**
     * @throws Exception
     */
    private function getPromoter(Retriever $retriever, bool $saved = true): Promoter
    {
        return new Promoter($retriever, $this->createConfiguredMock(Saver::class, ['save' => $saved]));
    }
}
