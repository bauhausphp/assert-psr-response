<?php

namespace Fefas\AssertPsrResponse\Assertions;

use PHPUnit\Framework\TestCase;
use Fefas\AssertPsrResponse\PsrResponseDoubleBuilder;

class HeaderLineAssertionTest extends TestCase
{
    use PsrResponseDoubleBuilder;

    /**
     * @test
     */
    public function isNotFailedIfResponseHeaderLineEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $headerLineAssertion = new HeaderLineAssertion(
            'text/html',
            'Content-Type',
            $responseToAssert
        );

        $isFailed = $headerLineAssertion->isFailed();

        $this->assertFalse($isFailed);
    }

    /**
     * @test
     */
    public function returnNullFailedMessageIfResponseHeaderLineEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $headerLineAssertion = new HeaderLineAssertion(
            'text/html',
            'Content-Type',
            $responseToAssert
        );

        $nullFailedMessage = $headerLineAssertion->failedMessage();

        $this->assertNull($nullFailedMessage);
    }

    /**
     * @test
     */
    public function isFailedIfResponseHeaderLineNotEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $headerLineAssertion = new HeaderLineAssertion(
            'application/json',
            'Content-Type',
            $responseToAssert
        );

        $isFailed = $headerLineAssertion->isFailed();

        $this->assertTrue($isFailed);
    }

    /**
     * @test
     */
    public function returnFailedMessageIfResponseHeaderLineNotEqualsTheExpected(): void
    {
        $responseToAssert = $this->responseWithHeaderLine('Content-Type', 'text/html');
        $headerLineAssertion = new HeaderLineAssertion(
            'application/json',
            'Content-Type',
            $responseToAssert
        );

        $failedMessage = $headerLineAssertion->failedMessage();

        $this->assertEquals(
            'Failed asserting response header line \'Content-Type\' \'text/html\' to the expected \'application/json\'',
            $failedMessage
        );
    }
}