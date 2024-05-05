<?php

namespace OverkillFibonacci;

abstract class Fibonacci
{
    public function __invoke(\GMP $number): \GMP
    {
        if (0 === gmp_cmp($number, 0)) {
            return $this->fibonacci0();
        }

        if (0 === gmp_cmp($number, 1)) {
            return $this->fibonacci1();
        }

        return $this->fibonacciN($number);
    }

    protected function fibonacci0(): \GMP
    {
        return new \GMP(0);
    }

    protected function fibonacci1(): \GMP
    {
        return new \GMP(1);
    }

    abstract protected function fibonacciN(\GMP $number): \GMP;
}
