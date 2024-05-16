<?php

namespace OverkillFibonacci\Adapters;

use OverkillFibonacci\Fibonacci;
use Psr\SimpleCache\CacheInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class WithCache extends Fibonacci
{
    private Fibonacci $fibonacci;
    private CacheInterface $cache;

    public function __construct(
        #[Autowire(service: 'http_fibonacci')]
        Fibonacci $fibonacci,
        #[Autowire(service: 'fibonacci.cache.psr16')]
        CacheInterface $cache
    ) {
        $this->fibonacci = $fibonacci;
        $this->cache = $cache;
    }

    protected function fibonacciN(\GMP $number): \GMP
    {
        $fibonacci = $this->cache->get((string) $number);
        if (null !== $fibonacci) {
            return $fibonacci;
        }

        $fibonacci = $this->fibonacci->fibonacciN($number);
        $this->cache->set((string) $number, $fibonacci);

        return $fibonacci;
    }
}
