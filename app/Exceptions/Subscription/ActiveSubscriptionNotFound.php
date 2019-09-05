<?php

namespace App\Exceptions\Subscription;

use Illuminate\Contracts\Support\Responsable;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ActiveSubscriptionNotFound extends HttpException implements Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
        ], $this->getStatusCode());
    }
}
