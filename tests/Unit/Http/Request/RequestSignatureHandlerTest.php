<?php

namespace Tests\Unit\Http\Request;

use App\Http\Requests\RequestSignatureHandler;
use Tests\TestCase;

class RequestSignatureHandlerTest extends TestCase
{
    function test_parameters_can_be_signed_without_expires_date()
    {
        $handler = $this->getRequestSignatureHandler();

        $data = $handler->signParameters([
            'action' => 'test',
        ]);

        $this->assertArrayHasKey('signature', $data);
        $this->assertArrayNotHasKey('expires', $data);
    }

    function test_parameters_can_be_signed_with_expires_date()
    {
        $handler = $this->getRequestSignatureHandler();

        $data = $handler->signParameters([
            'action' => 'test',
        ], now()->addDay());

        $this->assertArrayHasKey('signature', $data);
        $this->assertArrayHasKey('expires', $data);
    }

    function test_an_invalid_data_without_expires_date_cannot_pass_validation()
    {
        $handler = $this->getRequestSignatureHandler();

        $handler->signParameters(['action' => 'test',]);

        $this->assertFalse($handler->validate('invalid-signature', ['action' => 'test',]));
    }

    function test_valid_data_without_expires_date_can_pass_validation()
    {
        $handler = $this->getRequestSignatureHandler();

        $data = $handler->signParameters(['action' => 'test',]);

        $this->assertTrue($handler->validate($data['signature'], ['action' => 'test',]));
    }

    function test_an_invalid_data_with_expires_date_cannot_pass_validation()
    {
        $handler = $this->getRequestSignatureHandler();

        $handler->signParameters([
            'action' => 'test',
        ], $expires = now()->addDay());

        $this->assertFalse($handler->validate(
            'invalid-signature',
            ['action' => 'test',],
            $expires->getTimestamp()
        ));
    }

    function test_valid_data_with_expires_date_can_pass_validation()
    {
        $handler = $this->getRequestSignatureHandler();

        $data = $handler->signParameters([
            'action' => 'test',
        ], $expires = now()->addDay());

        $this->assertTrue($handler->validate(
            $data['signature'],
            ['action' => 'test',],
            $expires->getTimestamp()
        ));
    }

    function test_valid_data_with_nullable_expires_date_cannot_pass_validation()
    {
        $handler = $this->getRequestSignatureHandler();

        $data = $handler->signParameters([
            'action' => 'test',
        ], $expires = now()->addDay());

        $this->assertFalse($handler->validate(
            $data['signature'],
            ['action' => 'test',]
        ));
    }

    function test_valid_data_with_expired_expires_date_cannot_pass_validation()
    {
        $handler = $this->getRequestSignatureHandler();

        $data = $handler->signParameters([
            'action' => 'test',
        ], $expires = now()->subSecond());

        $this->assertFalse($handler->validate(
            $data['signature'],
            ['action' => 'test',],
            $expires->getTimestamp()
        ));
    }

    /**
     * @return RequestSignatureHandler
     */
    protected function getRequestSignatureHandler()
    {
        return new RequestSignatureHandler('http://localhost', 'secret-key');
    }
}
