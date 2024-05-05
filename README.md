# Overkill Fibonacci

This kata lets practice some symfony components usage.

## ... and just a little reminder about what is the Fibonacci sequence

The Fibonacci numbers may be defined by the recurrence relation

```math
\begin{equation}
F_0=0
\end{equation}
```
,

```math
\begin{equation}
F_1=1
\end{equation}
```
and

```math
\begin{equation}
F_{n}=F_{n-1}+F_{n-2}
\end{equation}
```
for n > 1.

You can go to the Wikipedia [article](https://en.wikipedia.org/wiki/Fibonacci_sequence) to dig even more into it.

## Task 1: Oh dear! Fibo is too slow!

Try to improve the performance of finding the Fibonacci sequence number.

In order to achieve that, you can have a look to [NaiveRecursionFibonacci](src/Adapters/NaiveRecursionFibonacciTest.php) class and its tests.

The acceptance one extends from a [contract test case](tests/Acceptance/Adapters/FibonacciAcceptanceContractTestCase.php) you can use as you please.
Have a look at the huge data provider in there xD.

__TIP 1__ : try to store previous calls results into a variable.

__TIP 2__ : try to get rid of the recursion to stop getting max execution stack errors. For problems like the Fibonacci sequence, where the recursion will never be cyclic, it is possible to transform recursive calls into a sequential (FIFO) list of calls.

## Task 2: Offer our fibonacci solution to the world via an endpoint

We have an endpoint http://localhost:8000/fibonacci that accepts a `number` query param that return its Fibonacci sequence number.

Users can then use a command to ask for the Fibonacci of a number that makes use of that endpoint remotely

```
$ bin/console fibonacci -h
Description:
  Calculate the Fibonacci sequence from a number

Usage:
  fibonacci <number>...
  f
  fibo

Arguments:
  number                The number you want to obtain the fibonacci sequence from

Options:
  -h, --help            Display help for the given command. When no command is given display help for the list command
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -e, --env=ENV         The Environment name. [default: "dev"]
      --no-debug        Switch off debug mode.
      --profile         Enables profiling (requires debug).
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```

The problem is that, even with the more performant solution, it wont be fast enough.

Consider using a cache that stores the API results in a persistent database like Redis.
You can make use of the Symfony Cache component already installed https://symfony.com/doc/current/cache.html

Modify the service definition and the autowiring as you see fit.

## Notes

The environment is built via a `make init`.

You can start the services like the api and the redis server with `make start`

If you mess something you can always do `make clean init` to rebuild everything.

You can open a terminal with `make bash` and launch the fibonacci command from there `bin/console f 100`.

## Troubleshooting

### Environment variables

If you use the Makefile you'll be fine for the most part.
But if you configure your IDE and you get errors related to missing environment vars, then make sure you have them defined in your settings.

Basically there are two:
- `UID` (your user id, typically obtained with `id -u` in Linux)
- `DOCKER_HOST_IP` (your host computer IP inside a container, typically the inet field of the `docker0` interface)
