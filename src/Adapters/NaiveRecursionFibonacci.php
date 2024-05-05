<?php

namespace OverkillFibonacci\Adapters;

use OverkillFibonacci\Fibonacci;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;

#[AsAlias(Fibonacci::class)]
class NaiveRecursionFibonacci extends Fibonacci
{
    protected function fibonacciN(\GMP $number): \GMP
    {
        return gmp_add(
            ($this)(gmp_sub($number, 1)),
            ($this)(gmp_sub($number, 2))
        );
    }
}
