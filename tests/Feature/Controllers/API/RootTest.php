<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\API;

use App\BusinessObjects\DTOs\Utils\Token;
use Illuminate\Http\Request;
use Illuminate\Testing\Fluent\AssertableJson;

class RootTest extends APITest
{
    private const string TYPE_INDEX = 'type';
    private const string NAME_INDEX = 'name';
    private const string STRING_TYPE = 'string';
    private const string PARAMETER_INDEX = 'parameters';
    private const string DESCRIPTION_INDEX = 'description';
    private const string ENDPOINT_INDEX = 'endpointExample';
    private const string ENDPOINT_TRANSLATIONS = self::API_TRANSLATIONS . 'endpoints.';
    private const string TOKEN_TRANSLATIONS = self::ENDPOINT_TRANSLATIONS . 'token.';
    private const string ACCOUNT_TRANSLATIONS = self::ENDPOINT_TRANSLATIONS . 'account.';
    private array $parameterIndexes = [self::TYPE_INDEX, self::NAME_INDEX];
    private array $resourceIndexes = [
        self::TYPE_INDEX,
        self::DESCRIPTION_INDEX,
        self::PARAMETER_INDEX,
        self::ENDPOINT_INDEX,
    ];

    /**
     * @dataProvider providerRole
     */
    public function testIndex(string $role = null): void
    {
        $header = $this->getHeader($this->getAuthorization($role));
        $this->getJson($this->domain, $header)->assertJson(fn(AssertableJson $json) => $json->has('Resources',
            fn(AssertableJson $resources) => $this->assertResources($resources, $role)));
    }

    public function testOptions(): void
    {
        $methods = [Request::METHOD_GET, Request::METHOD_OPTIONS, Request::METHOD_POST, Request::METHOD_PATCH];
        $this->withHeaders($this->getHeader())
             ->options($this->domain . '/allows')
             ->assertHeader('Allow', implode(', ', $methods));
    }

    public static function providerRole(): array
    {
        return [[], [Token::GUEST_ROLE], [Token::ADMIN_ROLE], [Token::RECRUITER_ROLE]];
    }

    private function getAuthorization(?string $role): array
    {
        $bearerToken = 'Bearer ';
        $bearerToken = match ($role) {
            Token::GUEST_ROLE => $bearerToken . 'test_token',
            Token::ADMIN_ROLE => $bearerToken . 'test_admin_token',
            Token::RECRUITER_ROLE => $bearerToken . 'test_recruiter_token',
            default => '',
        };

        return ['Authorization' => $bearerToken];
    }

    private function assertResources(AssertableJson $resources, string $role = null): AssertableJson
    {
        $resources = $this->assertPublicResources($resources);

        if (!empty($role)) {
            $resources = $this->assertTokenedResources($resources);
        }

        return $resources;
    }

    private function assertPublicResources(AssertableJson $resources): AssertableJson
    {
        return $resources->has('token (POST)', fn(AssertableJson $token) => $token->hasAll($this->resourceIndexes)
                                                                                  ->where(self::TYPE_INDEX,
                                                                                      Request::METHOD_POST)
                                                                                  ->where(self::DESCRIPTION_INDEX,
                                                                                      __(self::TOKEN_TRANSLATIONS
                                                                                         . 'request'))
                                                                                  ->has(self::PARAMETER_INDEX, 2)
                                                                                  ->has(self::PARAMETER_INDEX . '.0',
                                                                                      fn(AssertableJson $parameter
                                                                                      ) => $parameter->hasAll($this->parameterIndexes)
                                                                                                     ->where(self::NAME_INDEX,
                                                                                                         'username')
                                                                                                     ->where(self::TYPE_INDEX,
                                                                                                         self::STRING_TYPE))
                                                                                  ->has(self::PARAMETER_INDEX . '.1',
                                                                                      fn(AssertableJson $parameter
                                                                                      ) => $parameter->hasAll($this->parameterIndexes)
                                                                                                     ->where(self::NAME_INDEX,
                                                                                                         'password')
                                                                                                     ->where(self::TYPE_INDEX,
                                                                                                         self::STRING_TYPE))
                                                                                  ->where(self::ENDPOINT_INDEX,
                                                                                      $this->domain
                                                                                      . '/token?username=username&password=password'))
                         ->has('account', fn(AssertableJson $account) => $account->hasAll($this->resourceIndexes)
                                                                                 ->where(self::TYPE_INDEX,
                                                                                     Request::METHOD_POST)
                                                                                 ->where(self::DESCRIPTION_INDEX,
                                                                                     __(self::ACCOUNT_TRANSLATIONS
                                                                                        . 'request'))
                                                                                 ->has(self::PARAMETER_INDEX, 4)
                                                                                 ->has(self::PARAMETER_INDEX . '.0', fn(
                                                                                     AssertableJson $parameter
                                                                                 ) => $parameter->hasAll($this->parameterIndexes)
                                                                                                ->where(self::NAME_INDEX,
                                                                                                    'email')
                                                                                                ->where(self::TYPE_INDEX,
                                                                                                    self::STRING_TYPE))
                                                                                 ->has(self::PARAMETER_INDEX . '.1', fn(
                                                                                     AssertableJson $parameter
                                                                                 ) => $parameter->hasAll($this->parameterIndexes)
                                                                                                ->where(self::NAME_INDEX,
                                                                                                    'name')
                                                                                                ->where(self::TYPE_INDEX,
                                                                                                    self::STRING_TYPE))
                                                                                 ->has(self::PARAMETER_INDEX . '.2', fn(
                                                                                     AssertableJson $parameter
                                                                                 ) => $parameter->hasAll($this->parameterIndexes)
                                                                                                ->where(self::NAME_INDEX,
                                                                                                    'language')
                                                                                                ->where(self::TYPE_INDEX,
                                                                                                    self::STRING_TYPE))
                                                                                 ->has(self::PARAMETER_INDEX . '.3', fn(
                                                                                     AssertableJson $parameter
                                                                                 ) => $parameter->hasAll($this->parameterIndexes)
                                                                                                ->where(self::NAME_INDEX,
                                                                                                    'linkedin_profile')
                                                                                                ->where(self::TYPE_INDEX,
                                                                                                    self::STRING_TYPE))
                                                                                 ->where(self::ENDPOINT_INDEX,
                                                                                     $this->domain
                                                                                     . '/account?email=email&name=name&language=language&linkedin_profile=linkedin_profile'));
    }

    private function assertTokenedResources(AssertableJson $resources): AssertableJson
    {
        return $resources->has('token (GET)', fn(AssertableJson $token) => $token->hasAll($this->resourceIndexes)
                                                                                 ->where(self::TYPE_INDEX,
                                                                                     Request::METHOD_GET)
                                                                                 ->where(self::DESCRIPTION_INDEX,
                                                                                     __(self::TOKEN_TRANSLATIONS
                                                                                        . 'refresh'))
                                                                                 ->where(self::ENDPOINT_INDEX,
                                                                                     $this->domain . '/token'));
    }
}
