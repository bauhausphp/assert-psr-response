<?php

namespace Fefas\AssertPsrResponse;

use RuntimeException;
use PHPUnit\Framework\TestCase;

class AssertPsrResponseStatusCodeTest extends TestCase
{
    use PsrResponseDoubleBuilder;

    /**
     * @test
     */
    public function dontThrowAnyExceptionWhenStatusCodeEqualsTheExpected(): void
    {
        $responseStub = $this->responseWithStatusCode(200);
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->addStatusCodeToAssert(200);
        $assertResult = $assertPsrResponse->assert();

        $this->assertTrue($assertResult);
    }

    /**
     * @test
     */
    public function throwRuntimeExceptionWhenStatusCodeNotEqualsTheExpected(): void
    {
        $responseStub = $this->responseWithStatusCode(500);
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->addStatusCodeToAssert(200);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            "Failed asserting response status code '500' to the expected '200'"
        );

        $assertPsrResponse->assert();
    }
}
