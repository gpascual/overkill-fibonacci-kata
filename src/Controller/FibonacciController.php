<?php

declare(strict_types=1);

namespace OverkillFibonacci\Controller;

use OverkillFibonacci\Adapters\TailRecursionFibonacci;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class FibonacciController
{
    private $fibonacci;

    public function __construct(
        #[Autowire(service: TailRecursionFibonacci::class)]
        callable $fibonacci
    ) {
        $this->fibonacci = $fibonacci;
    }

    #[Route('/fibonacci')]
    public function index(Request $request): Response
    {
        return new JsonResponse(
            (string) ($this->fibonacci)(
                new \GMP($request->get('number', 0), 10)
            )
        );
    }
}
