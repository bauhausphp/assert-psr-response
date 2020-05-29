<?php

namespace Fefas\AssertPsrResponse;

use PHPUnit\Framework\TestCase;

class AssertPsrResponseComposeMismatchMessagesTest extends TestCase
{
    use PsrResponseDoubleBuilderTrait;
    use AssertPsrResponseExceptionTrait;

    /**
     * @test
     */
    public function throwRuntimeExceptionWithMismatchMessagesComposed(): void
    {
        $expectedExceptionMessage = <<<MSG
Failed matching response status code '500' with the expected '200'
Failed matching response header line 'Content-Type' 'text/html' with the expected 'application/json'
MSG;
        $responseStub = $this->responseWithStatusAndHeaderLine(500, 'Content-Type', 'text/html');
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->matchStatusCode(200);
        $assertPsrResponse->matchHeaderLine('Content-Type', 'application/json');

        $this->expectAssertPsrResponseExceptionWithMessage($expectedExceptionMessage);
        $assertPsrResponse->assert();
    }

    /**
     * @test
     */
    public function overrideOldMatcherWithNewOneWillCheckTheSameProperty(): void
    {
        $expectedExceptionMessage = <<<MSG
Failed matching response status code '201' with the expected '300'
Failed matching response header line 'Content-Type' 'text/html' with the expected 'application/json'
MSG;
        $responseStub = $this->responseWithStatusAndHeaderLine(201, 'Content-Type', 'text/html');
        $assertPsrResponse = new AssertPsrResponse($responseStub);

        $assertPsrResponse->matchStatusCode(200);
        $assertPsrResponse->matchStatusCode(300);
        $assertPsrResponse->matchHeaderLine('Content-Type', 'text/html');
        $assertPsrResponse->matchHeaderLine('Content-Type', 'application/json');

        $this->expectAssertPsrResponseExceptionWithMessage($expectedExceptionMessage);
        $assertPsrResponse->assert();
    }
}