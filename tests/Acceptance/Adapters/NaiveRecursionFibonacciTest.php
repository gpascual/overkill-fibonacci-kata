<?php

namespace OverkillFibonacci\Tests\Acceptance\Adapters;

use OverkillFibonacci\Adapters\NaiveRecursionFibonacci;

class NaiveRecursionFibonacciTest extends FibonacciAcceptanceContractTestCase
{
    protected function createFibonacciCallable(): callable
    {
        return new NaiveRecursionFibonacci();
    }
}
