<?php

namespace OverkillFibonacci\Adapters;

use OverkillFibonacci\Fibonacci;
use Symfony\Component\DependencyInjection\Attribute\AsAlias;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsAlias('http_fibonacci')]
#[Autoconfigure(public: true)]
class HttpFibonacci extends Fibonacci
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $fibonacciClient)
    {
        $this->httpClient = $fibonacciClient;
    }

    protected function fibonacciN(\GMP $number): \GMP
    {
        $result = $this->httpClient->request('GET', "/fibonacci?number={$number}");

        return new \GMP(json_decode($result->getContent()));
    }
}
