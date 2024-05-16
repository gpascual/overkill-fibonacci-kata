<?php

namespace OverkillFibonacci\Tests\Acceptance\Adapters;

use OverkillFibonacci\Adapters\NoRecursionFibonacci;
use OverkillFibonacci\Adapters\WithCache;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;

class WithCacheTest extends FibonacciAcceptanceContractTestCase
{
    protected function createFibonacciCallable(): callable
    {
        return new WithCache(
            new NoRecursionFibonacci(),
            new Psr16Cache(new ArrayAdapter())
        );
    }
}
