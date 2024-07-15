<?php

declare(strict_types=1);

namespace Tests\Unit\Utils;

use App\Utils\Errors as ErrorUtil;
use ReflectionClass;
use ReflectionException;
use Tests\TestCase;

class ErrorsTest extends TestCase
{
    /**
     * @throws ReflectionException
     */
    public function testGetCollectionErrorMessage(): void
    {
        $errors = new class() {
            use ErrorUtil;
        };

        $class = new ReflectionClass(get_class($errors));
        $method = $class->getMethod('getCollectionErrorMessage');
        $method->setAccessible(true);

        $variables = collect(['test_value_1', 'test_value_2']);
        $error = $method->invokeArgs($errors, ['test_variable', $variables, 'test_input']);

        $expectedError = '- The test_variable field must have the following values: "test_value_1","test_value_2". '
                         . '(Wrong input => "test_input")' . PHP_EOL;

        $this->assertSame($expectedError, $error);
    }
}
