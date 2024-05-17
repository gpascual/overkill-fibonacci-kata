<?php

namespace OverkillFibonacci\Tests\Acceptance\Adapters;

use OverkillFibonacci\Adapters\TailRecursionFibonacci;
use PHPUnit\Framework\TestCase;

class TailRecursionFibonacciTest extends FibonacciAcceptanceContractTestCase
{
    protected function createFibonacciCallable(): callable
    {
        return new TailRecursionFibonacci();
    }
}
