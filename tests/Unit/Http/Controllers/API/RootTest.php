<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Controllers\API;

use App\Http\Controllers\API\Root;
use Dingo\Api\Http\Response;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\JWT;
use PHPUnit\Framework\MockObject\Exception;

use function PHPUnit\Framework\returnSelf;

class RootTest extends APITests
{
    private const string TYPE_INDEX = 'type';
    private const string NAME_INDEX = 'name';
    private const string TOKEN_PATH = 'tokens';
    private const string STRING_TYPE = 'string';
    private const string RESOURCES = 'Resources';
    private const string ACCOUNT_PATH = 'accounts';
    private const string DOMAIN = 'https://domain.test/';
    private const string PARAMETER_INDEX = 'parameters';
    private const string DESCRIPTION_INDEX = 'description';
    private const string ENDPOINT_INDEX = 'endpointExample';
    private const string ENDPOINT_TRANSLATIONS = self::API_TRANSLATIONS . 'endpoints.';
    private const string TOKEN_TRANSLATIONS = self::ENDPOINT_TRANSLATIONS . 'tokens.';
    private const string ACCOUNT_TRANSLATIONS = self::ENDPOINT_TRANSLATIONS . 'accounts.';
    private const array PUBLIC_RESOURCES_TO_CHECK = [
        self::TOKEN_PATH . ' (POST)' => [
            self::TYPE_INDEX        => Request::METHOD_POST,
            self::PARAMETER_INDEX   => 2,
            self::DESCRIPTION_INDEX => self::TOKEN_TRANSLATIONS . 'request',
            self::ENDPOINT_INDEX    => self::DOMAIN . 'tokens?username=username&password=password'
        ],
        self::ACCOUNT_PATH           => [
            self::TYPE_INDEX        => Request::METHOD_POST,
            self::PARAMETER_INDEX   => 4,
            self::DESCRIPTION_INDEX => self::ACCOUNT_TRANSLATIONS . 'request',
            self::ENDPOINT_INDEX    => self::DOMAIN
                                       . 'accounts?email=email&name=name&language=language&linkedin_profile=linkedin_profile'
        ]
    ];
    private const array TOKENED_RESOURCES_TO_CHECK = [
        self::TOKEN_PATH . ' (GET)' => [
            self::TYPE_INDEX        => Request::METHOD_GET,
            self::PARAMETER_INDEX   => 0,
            self::DESCRIPTION_INDEX => self::TOKEN_TRANSLATIONS . 'refresh',
            self::ENDPOINT_INDEX    => self::DOMAIN . 'tokens'
        ]
    ];

    private Root $controller;

    /**
     * @dataProvider providerToken
     * @throws Exception
     */
    public function testIndex(string $token = null): void
    {
        $request = $this->getRequest(['bearerToken' => $token]);
        $mockedTokenManager = $this->createConfiguredMock(JWT::class, ['setToken' => returnSelf(), 'check' => true]);
        $index = json_decode($this->controller->index($request, $mockedTokenManager)->content(), true);

        $this->assertIsArray($index);
        $this->assertIsArray($index[self::RESOURCES]);
        $this->assertArrayHasKey(self::RESOURCES, $index);

        $resources = self::PUBLIC_RESOURCES_TO_CHECK;

        if (!empty($token)) {
            $resources = array_merge($resources, self::TOKENED_RESOURCES_TO_CHECK);
        }

        collect($resources)->each(function (array $config, string $resource) use ($index) {
            $this->assertResources($index[self::RESOURCES][$resource], $config);
        });

        $tokenPath = $index[self::RESOURCES][self::TOKEN_PATH . ' (POST)'];
        $this->assertSame('username', $tokenPath[self::PARAMETER_INDEX][0][self::NAME_INDEX]);
        $this->assertSame('password', $tokenPath[self::PARAMETER_INDEX][1][self::NAME_INDEX]);
        $this->assertSame(self::STRING_TYPE, $tokenPath[self::PARAMETER_INDEX][0][self::TYPE_INDEX]);
        $this->assertSame(self::STRING_TYPE, $tokenPath[self::PARAMETER_INDEX][1][self::TYPE_INDEX]);

        $accountPath = $index[self::RESOURCES][self::ACCOUNT_PATH];
        $this->assertSame('name', $accountPath[self::PARAMETER_INDEX][1][self::NAME_INDEX]);
        $this->assertSame('email', $accountPath[self::PARAMETER_INDEX][0][self::NAME_INDEX]);
        $this->assertSame('language', $accountPath[self::PARAMETER_INDEX][2][self::NAME_INDEX]);
        $this->assertSame(self::STRING_TYPE, $accountPath[self::PARAMETER_INDEX][0][self::TYPE_INDEX]);
        $this->assertSame(self::STRING_TYPE, $accountPath[self::PARAMETER_INDEX][1][self::TYPE_INDEX]);
        $this->assertSame(self::STRING_TYPE, $accountPath[self::PARAMETER_INDEX][2][self::TYPE_INDEX]);
        $this->assertSame(self::STRING_TYPE, $accountPath[self::PARAMETER_INDEX][3][self::TYPE_INDEX]);
        $this->assertSame('linkedin_profile', $accountPath[self::PARAMETER_INDEX][3][self::NAME_INDEX]);
    }

    public function testOptions(): void
    {
        $data = $this->controller->options();

        $expectedMethods = [Request::METHOD_GET, Request::METHOD_OPTIONS, Request::METHOD_POST];

        $this->assertEquals(Response::HTTP_OK, $data->getStatusCode());
        $this->assertSame(implode(', ', $expectedMethods), $data->headers->get('Allow'));
    }

    public static function providerToken(): array
    {
        return [[], ['test.token.test_token']];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->controller = new Root();
    }

    private function assertResources(array $resource, array $config): void
    {
        $this->assertArrayHasKey(self::TYPE_INDEX, $resource);
        $this->assertIsArray($resource[self::PARAMETER_INDEX]);
        $this->assertArrayHasKey(self::ENDPOINT_INDEX, $resource);
        $this->assertArrayHasKey(self::PARAMETER_INDEX, $resource);
        $this->assertArrayHasKey(self::DESCRIPTION_INDEX, $resource);
        $this->assertSame($config[self::TYPE_INDEX], $resource[self::TYPE_INDEX]);
        $this->assertSame($config[self::ENDPOINT_INDEX], $resource[self::ENDPOINT_INDEX]);
        $this->assertCount($config[self::PARAMETER_INDEX], $resource[self::PARAMETER_INDEX]);
        $this->assertSame(__($config[self::DESCRIPTION_INDEX]), $resource[self::DESCRIPTION_INDEX]);

        for ($i = 0; $i < $config[self::PARAMETER_INDEX]; $i++) {
            $this->assertIsArray($resource[self::PARAMETER_INDEX][$i]);
            $this->assertArrayHasKey(self::NAME_INDEX, $resource[self::PARAMETER_INDEX][$i]);
            $this->assertArrayHasKey(self::TYPE_INDEX, $resource[self::PARAMETER_INDEX][$i]);
        }
    }
}
