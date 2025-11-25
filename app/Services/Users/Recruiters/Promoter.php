<?php

declare(strict_types=1);

namespace App\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\BusinessObjects\DTOs\Users\Technician;
use App\BusinessObjects\Models\Users\Recruiter as RecruiterModel;
use App\BusinessObjects\Models\Users\Technician as TechnicianModel;
use App\Events\Users\Recruiters\Promoted as RecruiterPromotedEvent;
use App\Exceptions\Services\Users\Recruiters\InvalidPromotionException;
use App\Exceptions\Services\Users\Recruiters\PromotionException;
use App\Exceptions\Services\Users\UserNotFoundException;
use App\Services\Retriever;
use App\Services\Saver;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

readonly class Promoter
{
    public function __construct(private Retriever $retriever, private Saver $saver)
    {
    }

    /**
     * @throws PromotionException
     * @throws UserNotFoundException
     * @throws InvalidPromotionException
     */
    public function promote(string $email): void
    {
        $recruiter = $this->getRecruiter($email);

        $this->promoteRecruiter($recruiter);

        event(new RecruiterPromotedEvent($recruiter));
    }

    /**
     * @throws UserNotFoundException
     * @throws InvalidPromotionException
     */
    private function getRecruiter(string $email): Recruiter
    {
        try {
            /** @var Recruiter $recruiter */
            $recruiter = $this->retriever->retrieveByField('email', $email);
        } catch (ModelNotFoundException) {
            throw new UserNotFoundException(new Recruiter(email: $email), 'email');
        }

        if (empty($recruiter->getLinkedinProfile())) {
            throw new InvalidPromotionException($recruiter);
        }

        return $recruiter;
    }

    /**
     * @throws PromotionException
     */
    private function promoteRecruiter(Recruiter $recruiter): void
    {
        $technician = new Technician(
            name: $recruiter->getName(),
            email: $recruiter->getEmail(),
            language: $recruiter->getLanguage(),
            linkedinProfile: $recruiter->getLinkedinProfile()
        );

        DB::beginTransaction();

        if (empty($this->saver->save($technician))) {
            throw new PromotionException($recruiter);
        }

        $recruiterModel = RecruiterModel::find($recruiter->getIdentifier());
        $technicianModel = TechnicianModel::whereEmail($technician->getEmail())->first();

        $technicianModel->password = $recruiterModel->password;

        if (empty($technicianModel->save())) {
            throw new PromotionException($recruiter);
        }

        if (empty($recruiterModel->delete())) {
            throw new PromotionException($recruiter);
        }

        DB::commit();
    }
}
