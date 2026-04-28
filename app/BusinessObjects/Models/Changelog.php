<?php

declare(strict_types=1);

namespace App\BusinessObjects\Models;

use App\BusinessObjects\Models\Users\Admin;
use App\BusinessObjects\Models\Users\Recruiter;
use App\BusinessObjects\Models\Users\Technician;
use App\Events\Changelogs\Saving;
use Database\Factories\ChangelogFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Changelog extends Model
{
    use HasFactory, HasUuids;

    public const string ACTION_SAVED = 'saved';
    public const string ACTION_DELETED = 'deleted';

    public const array ACTIONS = [self::ACTION_SAVED, self::ACTION_DELETED];
    public const array ENTITY_TYPES = [Admin::class, Recruiter::class, Technician::class];

    public $timestamps = false;

    protected $fillable = ['type', 'action', 'entity_id', 'value_payload'];

    protected $dispatchesEvents = ['saving' => Saving::class];

    protected static function newFactory(): ChangelogFactory
    {
        return ChangelogFactory::new();
    }
}
