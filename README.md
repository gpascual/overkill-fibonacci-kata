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

## Task 3: Obtaining intermediate results.

There is a new requirement on top of Task 2.

We need to compute the intermediate results for Fibonacci. Example: if the request is for `fibonacci(3)`, return the fibonacci computation all intermediate numbers (fibonnaci of 0...3, all included).

As an architecture kata, design a system that supports this new requirement, with the condition of supporting the existing behaviour in clients, and as fewer pieces of new technology as possible.

Expected:

1. Document (or a few notes) of 1/2-1 page documenting:
2. Where to introduce these changes
3. Which new parts or modified parts are affected
4. Which new pieces of technology (if any) are needed
5. How do we ensure the continuity of existing features
6. Other alternatives that you considered and why you didn't choose them

How to proceed:

1. Explain this exercise.
2. Break into groups. Each group creates a solution. ~10-15 minutes for that. Create such document
3. Get together and discuss the solutions.

## Task 4: Oh no! The Fibonorials are here to terrorize us!!!

A Fibonorial number is the product of all the Fibonacci sequence from *F<sub>n</sub>* to *F<sub>1</sub>*.

```math
\begin{equation}
n!_F := \prod_{\substack{i = 1}} ^ {n} F_i, n \geq 1 
\end{equation}
```

You can also represent it by the recurrence relation:

```math
\begin{equation}
0!_F := 1
\end{equation}
```
and

```math
\begin{equation}
n!_F := F_n  \times \left( n - 1 \right)!_F
\end{equation}
```
for n > 0.

Again! You can go to the Wikipedia [article](https://en.wikipedia.org/wiki/Fibonorial) to dig even more into it.

We need to offer a `fibonorial` command that performs reasonably and works remotely in the same fashion as the previous command.

Please! Consider everything we have done so far in previous tasks (remove recursion, cache results, intermediate results).

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
