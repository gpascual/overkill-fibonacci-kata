<?php

namespace OverkillFibonacci\Tests\Acceptance\Adapters;

use OverkillFibonacci\Adapters\NoRecursionFibonacci;

class NoRecursionFibonacciTest extends FibonacciAcceptanceContractTestCase
{
    protected function createFibonacciCallable(): callable
    {
        return new NoRecursionFibonacci();
    }
}
