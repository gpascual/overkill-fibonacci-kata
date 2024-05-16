<?php

namespace OverkillFibonacci\Adapters;

use OverkillFibonacci\Fibonacci;

class NoRecursionFibonacci extends Fibonacci
{
    protected function fibonacciN(\GMP $number): \GMP
    {
        $fiboN2 = $this->fibonacci0();
        $fiboN1 = $this->fibonacci1();
        $fiboN = $fiboN1 + $fiboN2;
        $current = 2;

        while (gmp_cmp($current, $number) < 0) {
            $fiboN2 = $fiboN1;
            $fiboN1 = $fiboN;
            $fiboN = $fiboN1 + $fiboN2;
            $current = gmp_add($current, 1);
        }

        return $fiboN;
    }
}
