<?php

namespace App\Services\Stripe;

class Payload
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->data['type'];
    }

    /**
     * Get customer ID
     *
     * @return string
     */
    public function getCustomerId(): string
    {
        return $this->data['data']['object']['customer'];
    }

    /**
     * Get object data
     *
     * @return array
     */
    public function getObject(): array
    {
        return $this->data['data']['object'];
    }

    /**
     * Get object ID
     *
     * @return string
     */
    public function getObjectId(): string
    {
        return $this->data['data']['object']['id'];
    }

    /**
     * @return string
     */
    public function getPaymentIntent(): string
    {
        return $this->data['data']['object']['payment_intent'];
    }
}