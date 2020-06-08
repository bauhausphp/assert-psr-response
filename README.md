[![Build Status](https://img.shields.io/github/workflow/status/bauhausphp/assert-psr-response/Build?style=flat-square)](https://github.com/bauhausphp/assert-psr-response/actions?query=workflow%3ABuild)
[![Coverage](https://img.shields.io/codecov/c/github/bauhausphp/assert-psr-response?style=flat-square)](https://codecov.io/gh/bauhausphp/assert-psr-response)

[![Stable Version](https://img.shields.io/packagist/v/bauhaus/assert-psr-response?style=flat-square)](https://packagist.org/packages/bauhaus/assert-psr-response)
[![Downloads](https://img.shields.io/packagist/dt/bauhaus/assert-psr-response?style=flat-square)](https://packagist.org/packages/bauhaus/assert-psr-response)
[![PHP Version](https://img.shields.io/packagist/php-v/bauhaus/assert-psr-response?style=flat-square)](composer.json)
[![License](https://img.shields.io/github/license/bauhausphp/assert-psr-response?style=flat-square)](LICENSE)

> **Important** this package won't worry about backward compatibily for `v0.*`
> versions.

# Assert PSR Response

This composer package aims to provide an easy way to assert
[PSR-7](http://www.php-fig.org/psr/psr-7/) responses.

## Motivation

I created this package because my constant need to assert only certain values of
PSR responses during testing, for example feature APIs testing using the
[Behat](http://behat.org/en/latest/) framework.

## Installation

Install it using [Composer](https://getcomposer.org/):

```shell
$ composer require bauhaus/assert-psr-response
```

## Available Matchers

Here are the available matchers so far:

* Status Code:
  ```php
  matchStatusCode(int $expected): void
  ```

* Header Line:
  ```php
  matchHeaderLine(string $headerName, string $expected): void
  ```

* JSON Body:
  ```php
  matchJsonBody(string $expected): void
  ```

## Usage

The class `AssertPsrResponse` allows the assertion of certain PSR-7 response
values. That means you don't have to verify the hole PSR-7 response object,
instead you can just assert the fields which are relevants for your current
case. See the samples bellow:

1. Assert Status Code that matches the expected:

   ```php
   <?php

   use Bauhaus\AssertPsrResponse\AssertPsrResponse;

   $psrResponse = // retrieve it from somewhere ...
   $psrResponse = $psrResponse->withStatus(200);

   $assertPsrResponse = new AssertPsrResponse($psrResponse);
   $assertPsrResponse->matchStatusCode(200);

   $assertPsrResponse->assert();
   // return true and don't throw any exception
   ```

2. Assert Status Code that doesn't match the expected

   ```php
   <?php

   use Bauhaus\AssertPsrResponse\AssertPsrResponse;

   $psrResponse = // retrieve it from somewhere ...
   $psrResponse = $psrResponse->withStatus(500);

   $assertPsrResponse = new AssertPsrResponse($psrResponse);
   $assertPsrResponse->matchStatusCode(200);

   $assertPsrResponse->assert();
   // throw RuntimeException with message:
   // Failed matching response status code '500' with the expected '200'
   ```

3. Assert Status Code and Header Line that match partly the expected

   ```php
   <?php

   use Bauhaus\AssertPsrResponse\AssertPsrResponse;

   $psrResponse = // retrieve it from somewhere ...
   $psrResponse = $psrResponse
       ->withStatus(200)
       ->withHeader('Content-Type', 'application/json');

   $assertPsrResponse = new AssertPsrResponse($psrResponse);
   $assertPsrResponse->matchStatusCode(200);
   $assertPsrResponse->matchHeaderLine('Content-Type', 'text/html');

   $assertPsrResponse->assert();
   // throw RuntimeException with message:
   // Failed matching response header line 'Content-Type' 'application/json' with the expected 'text/html'
   ```

4. Assert Status Code and Header Line that don't match the expected

   ```php
   <?php

   use Bauhaus\AssertPsrResponse\AssertPsrResponse;

   $psrResponse = // retrieve it from somewhere ...
   $psrResponse = $psrResponse
       ->withStatus(500)
       ->withHeader('Content-Type', 'text/html');

   $assertPsrResponse = new AssertPsrResponse($psrResponse);
   $assertPsrResponse->matchStatusCode(200);
   $assertPsrResponse->matchHeaderLine('Content-Type', 'application/json');

   $assertPsrResponse->assert();
   // throw RuntimeException with message:
   // Failed matching response status code '500' with the expected '200'
   // Failed matching response header line 'Content-Type' 'text/html' with the expected 'application/json'
   ```

## Contribution

There is two ways to contribute with this project. The first one is by opening
an issue [here](https://github.com/bauhausphp/assert-psr-response/issues). The second
one is by coding:

1. Fork this project and clone it on your local dev environment
2. Install dependencies throught the command: `composer install`
3. Run the locally tests before ubmiting a pull request:
  * To test code standards: `composer run test:cs`
  * To run unit tests: `composer run test:unit`
  * To run all tests in a roll: `composer run tests`
