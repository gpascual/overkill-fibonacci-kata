<?php

namespace OverkillFibonacci\Adapters;

use OverkillFibonacci\Fibonacci;

use function Functional\tail_recursion;

class TailRecursionFibonacci extends Fibonacci
{
    protected function nextFibonacci(
        callable $fibonacciTailRecursion,
        \GMP $from,
        \GMP $to,
        \GMP $fiboN1,
        \GMP $fiboN2
    ) {
        $fibo = gmp_add($fiboN1, $fiboN2);

        if (0 === gmp_cmp($from, $to)) {
            return $fibo;
        }

        return $fibonacciTailRecursion(gmp_add($from, 1), $to, $fibo, $fiboN1);
    }

    final protected function fibonacciN(\GMP $number): \GMP
    {
        return $this->tailRecursionCallable()(new \GMP(2), $number, $this->fibonacci1(), $this->fibonacci0());
    }

    private function tailRecursionCallable(): callable
    {
        $fibonacciTailRecursion = tail_recursion(
            function (
                \GMP $from,
                \GMP $to,
                \GMP $fiboN1,
                \GMP $fiboN2
            ) use (&$fibonacciTailRecursion) {
                return $this->nextFibonacci($fibonacciTailRecursion, $from, $to, $fiboN1, $fiboN2);
            }
        );

        return $fibonacciTailRecursion;
    }
}
