<?php

namespace App\Services\Stripe\Contracts;

use App\Services\Stripe\Payload;
use Illuminate\Http\Response;

interface Event
{
    /**
     * @param Payload $payload
     *
     * @return Response
     */
    public function handle(Payload $payload): Response;
}