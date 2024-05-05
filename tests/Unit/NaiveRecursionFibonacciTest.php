<?php

namespace OverkillFibonacci\Tests\Unit\Adapters;

use OverkillFibonacci\Adapters\NaiveRecursionFibonacci;
use PHPUnit\Framework\TestCase;

class NaiveRecursionFibonacciTest extends TestCase
{
    private $sut;

    protected function setUp(): void
    {
        $this->sut = new NaiveRecursionFibonacci();
    }

    /**
     * @test
     *
     * @dataProvider fibonacciNumbers
     */
    public function shouldReturnTheFibonacciSequence(\GMP $expectedResult, \GMP $number): void
    {
        $result = ($this->sut)($number);

        self::assertEquals(0, gmp_cmp($expectedResult, $result), "$expectedResult and $result are not the same");
    }

    public function fibonacciNumbers(): array
    {
        return [
            'given 0, should return 0' => [new \GMP(0, 10), new \GMP(0, 10)],
            'given 1, should return 1' => [new \GMP(1, 10), new \GMP(1, 10)],
            'otherwise, should return fibo(n-1) + fibo(n-2)' => [new \GMP(3, 10), new \GMP(4, 10)],
        ];
    }
}
