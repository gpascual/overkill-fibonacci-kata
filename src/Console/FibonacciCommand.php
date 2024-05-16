<?php

namespace OverkillFibonacci\Console;

use OverkillFibonacci\Adapters\WithCache;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

use function Functional\map;

#[AsCommand(
    name: 'fibonacci',
    description: 'Calculate the Fibonacci sequence from a number',
    aliases: ['f', 'fibo']
)]
class FibonacciCommand extends Command
{
    private $fibonacci;

    public function __construct(
        #[Autowire(service: WithCache::class)]
        callable $fibonacci
    ) {
        parent::__construct();
        $this->fibonacci = $fibonacci;
    }

    protected function configure(): void
    {
        $this->addArgument(
            'number',
            InputArgument::REQUIRED | InputArgument::IS_ARRAY,
            'The number you want to obtain the fibonacci sequence from'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $numbers = map(
            $input->getArgument('number'),
            fn ($number) => new \GMP($number)
        );

        foreach ($numbers as $number) {
            $response = ($this->fibonacci)($number);

            $output->writeln([
                "The Fibonacci sequence of $number is:",
                $response,
                '',
            ]);
        }

        return self::SUCCESS;
    }
}
