<?php

namespace OverkillFibonacci\Tests\Acceptance\Adapters;

use OverkillFibonacci\Adapters\HttpFibonacci;

class HttpFibonacciTest extends FibonacciAcceptanceContractTestCase
{
    protected function createFibonacciCallable(): callable
    {
        self::bootKernel();

        return static::getContainer()->get(HttpFibonacci::class);
    }
}
