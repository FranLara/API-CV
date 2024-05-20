<?php

declare(strict_types=1);

namespace Tests\Feature\Controllers\API;

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
        self::ENDPOINT_INDEX
    ];

    public function testIndex(): void
    {
        $this->getJson($this->domain, $this->getHeader())->assertJson(fn(AssertableJson $json
        ) => $json->has('Resources', fn(AssertableJson $resources) => $resources->has('token (POST)',
            fn(AssertableJson $token) => $token->hasAll($this->resourceIndexes)
                                               ->where(self::TYPE_INDEX, Request::METHOD_POST)
                                               ->where(self::DESCRIPTION_INDEX,
                                                   __(self::TOKEN_TRANSLATIONS . 'request'))
                                               ->has(self::PARAMETER_INDEX, 2)
                                               ->has(self::PARAMETER_INDEX . '.0', fn(AssertableJson $parameter
                                               ) => $parameter->hasAll($this->parameterIndexes)
                                                              ->where(self::NAME_INDEX, 'username')
                                                              ->where(self::TYPE_INDEX, self::STRING_TYPE))
                                               ->has(self::PARAMETER_INDEX . '.1', fn(AssertableJson $parameter
                                               ) => $parameter->hasAll($this->parameterIndexes)
                                                              ->where(self::NAME_INDEX, 'password')
                                                              ->where(self::TYPE_INDEX, self::STRING_TYPE))
                                               ->where(self::ENDPOINT_INDEX,
                                                   $this->domain . '/token?username=username&password=password'))
                                                                                ->has('account',
                                                                                    fn(AssertableJson $account
                                                                                    ) => $account->hasAll($this->resourceIndexes)
                                                                                                 ->where(self::TYPE_INDEX,
                                                                                                     Request::METHOD_POST)
                                                                                                 ->where(self::DESCRIPTION_INDEX,
                                                                                                     __(self::ACCOUNT_TRANSLATIONS
                                                                                                        . 'request'))
                                                                                                 ->has(self::PARAMETER_INDEX,
                                                                                                     4)
                                                                                                 ->has(self::PARAMETER_INDEX
                                                                                                       . '.0', fn(
                                                                                                     AssertableJson $parameter
                                                                                                 ) => $parameter->hasAll($this->parameterIndexes)
                                                                                                                ->where(self::NAME_INDEX,
                                                                                                                    'email')
                                                                                                                ->where(self::TYPE_INDEX,
                                                                                                                    self::STRING_TYPE))
                                                                                                 ->has(self::PARAMETER_INDEX
                                                                                                       . '.1', fn(
                                                                                                     AssertableJson $parameter
                                                                                                 ) => $parameter->hasAll($this->parameterIndexes)
                                                                                                                ->where(self::NAME_INDEX,
                                                                                                                    'name')
                                                                                                                ->where(self::TYPE_INDEX,
                                                                                                                    self::STRING_TYPE))
                                                                                                 ->has(self::PARAMETER_INDEX
                                                                                                       . '.2', fn(
                                                                                                     AssertableJson $parameter
                                                                                                 ) => $parameter->hasAll($this->parameterIndexes)
                                                                                                                ->where(self::NAME_INDEX,
                                                                                                                    'language')
                                                                                                                ->where(self::TYPE_INDEX,
                                                                                                                    self::STRING_TYPE))
                                                                                                 ->has(self::PARAMETER_INDEX
                                                                                                       . '.3', fn(
                                                                                                     AssertableJson $parameter
                                                                                                 ) => $parameter->hasAll($this->parameterIndexes)
                                                                                                                ->where(self::NAME_INDEX,
                                                                                                                    'linkedin_profile')
                                                                                                                ->where(self::TYPE_INDEX,
                                                                                                                    self::STRING_TYPE))
                                                                                                 ->where(self::ENDPOINT_INDEX,
                                                                                                     $this->domain
                                                                                                 	. '/account?email=email&name=name&language=language&linkedin_profile=linkedin_profile'))->has('token (GET)',fn(AssertableJson $token) => $token->hasAll($this->resourceIndexes)->where(self::TYPE_INDEX, Request::METHOD_GET)->where(self::DESCRIPTION_INDEX,
                                                                                                 		__(self::TOKEN_TRANSLATIONS . 'refresh'))->where(self::ENDPOINT_INDEX,
                                                                                                 			$this->domain . '/token'))));
    }

    public function testOptions(): void
    {
        $methods = [Request::METHOD_GET, Request::METHOD_OPTIONS, Request::METHOD_POST, Request::METHOD_PATCH];
        $this->withHeaders($this->getHeader())
             ->options($this->domain . '/allows')
             ->assertHeader('Allow', implode(', ', $methods));
    }
}
