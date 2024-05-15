<?php
declare(strict_types = 1);

namespace App\BusinessObjects\Models\Users;

use App\Events\ModelSaved;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

abstract class User extends Model implements JWTSubject, AuthenticableContract
{
	use Notifiable, HasFactory, Authenticatable, HasUuids;

	public $timestamps = false;

	protected $hidden = ['password'];

	protected $dispatchesEvents = ['saved' => ModelSaved::class];

	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	public function getJWTCustomClaims(): array
	{
		return [];
	}
}
