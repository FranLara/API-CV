<?php

declare(strict_types=1);

namespace App\BusinessObjects\Models;

use App\Events\Changelogs\Saving;
use Database\Factories\ChangelogFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Changelog extends Model
{
    use HasFactory, HasUuids;

    public $timestamps = false;

    protected $fillable = ['type', 'entity_id', 'value_payload'];

    protected $dispatchesEvents = ['saving' => Saving::class];

    protected static function newFactory(): ChangelogFactory
    {
        return ChangelogFactory::new();
    }
}
