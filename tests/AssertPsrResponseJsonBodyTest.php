<?php

namespace Fefas\AssertPsrResponse;

use RuntimeException;
use PHPUnit\Framework\TestCase;

class AssertPsrResponseJsonBodyTest extends TestCase
{
    use PsrResponseDoubleBuilder;

    /**
     * @test
     */
    public function dontThrowAnyExceptionWhenJsonBodyEqualsTheExpected(): void
    {
        $responseStub = $this->responseWithJsonBody('[1,2,3]');
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->matchJsonBodyContent('[1,2,3]');
        $assertResult = $assertPsrResponse->assert();

        $this->assertTrue($assertResult);
    }

    /**
     * @test
     */
    public function throwRuntimeExceptionWhenJsonBodyEqualsTheExpected(): void
    {
        $responseStub = $this->responseWithJsonBody('[1,3]');
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->matchJsonBodyContent('[1,2]');

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(
            "Failed matching response json body '[1,3]' with the expected '[1,2]'"
        );

        $assertPsrResponse->assert();
    }
}
