<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\API;

use Tests\Feature\FeatureTest;

abstract class APITest extends FeatureTest
{
    protected const string API_TRANSLATIONS = 'api.';
    protected string $domain;

    protected function setUp(): void
    {
        parent::setUp();

        $this->domain = env('API_DOMAIN');
    }

    protected function getHeader(): array
    {
        $acceptHeader = env('API_STANDARDS_TREE') . '.' . env('API_SUBTYPE') . '.' . env('API_VERSION');

        return ['Accept' => 'application/' . $acceptHeader . '+json', 'Authorization'=> 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2RvbWFpbi50ZXN0L3Rva2VuIiwiaWF0IjoxNzE1OTYyMDgxLCJleHAiOjE3MTU5NjU2ODEsIm5iZiI6MTcxNTk2MjA4MSwianRpIjoiMjBWYWZWMFhqYk1oU1g1bCIsInN1YiI6IjljMTBkYjA4LWQzNTktNGM0ZS05MmM4LTdmMTZiMTlhZTBlZiIsInBydiI6IjUxNzNmZTRmMjM1MTc2NDk3M2JiNmVmMDRlMmUxMGFkYTA0YTVhMGUiLCJyb2xlIjoiYWRtaW4ifQ.sdd-wyBHqyKxmglpnuhSi7F_cfth0fp9IGZ1VrSDhsg'];
    }
}
