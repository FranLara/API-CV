<?php

declare(strict_types=1);

namespace App\BusinessObjects\DTOs\Utils;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use function collect;

class Resource
{
    private string $host;
    private string $path;
    private string $type;
    private string $description;
    private Collection $parameters;

    public function __construct(
        string $path,
        Request $request,
        string $description,
        array $parameters = [],
        string $type = Request::METHOD_GET
    ) {
        $this->path = $path;
        $this->type = $type;
        $this->description = $description;
        $this->parameters = collect($parameters);
        $this->host = $request->getSchemeAndHttpHost();
    }

    public function getResource(): array
    {
        $parameters = $this->parameters->all();
        $endpoint = $this->host . '/' . explode(' ', $this->path)[0];

        if ($this->parameters->isNotEmpty()) {
            $endpoint .= '?' . $this->getParameterForEndpointExample($this->parameters->shift());
        }

        $this->parameters->each(function (array $parameter) use (&$endpoint) {
            $endpoint .= '&' . $this->getParameterForEndpointExample($parameter);
        });

        return [
            $this->path => [
                'type'            => $this->type,
                'description'     => $this->description,
                'parameters'      => $parameters,
                'endpointExample' => $endpoint
            ]
        ];
    }

    private function getParameterForEndpointExample(array $parameter): string
    {
        $param = $parameter['name'] . '=';

        $param .= match ($parameter['type']) {
            'int' => random_int(1, 31),
            'bool' => (bool)rand(0, 1),
            'string' => $parameter['name'],
        };

        return $param;
    }
}