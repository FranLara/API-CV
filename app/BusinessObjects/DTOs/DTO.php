<?php

declare(strict_types=1);

namespace App\BusinessObjects\DTOs;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use stdClass;
use Throwable;

abstract class DTO
{
    protected ?string $identifier;

    public function __construct(?string $identifier = null)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function toPayload(): Collection
    {
        return $this->toArray(collect(get_object_vars($this)));
    }

    protected function toArray(Collection $variables): Collection
    {
        return $variables->reject(function ($value) {
            return is_null($value);
        })->mapWithKeys(function ($value, string $key) {
            if (Str::of($key)->exactly('psswd')) {
                return [$key => '[HIDDEN]'];
            }
            if (is_array($value)) {
                return [$key => $this->toArray(collect($value))];
            }

            try {
                return $this->getObjectVariable($key, $value);
            } catch (Throwable $e) {
                return [$key => $value];
            }
        });
    }

    private function getObjectVariable(string $key, $value): array
    {
        return match (get_class($value)) {
            Carbon::class => [$key => $value->toDateTime()],
            Collection::class => [$key => $this->toArray($value)],
            stdClass::class => [$key => $this->toArray(collect(json_decode(json_encode($value))))],
            default => [$key => $value->toPayload()],
        };
    }
}

