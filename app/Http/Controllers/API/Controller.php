<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    /**
     * @param array $data
     * @return JsonResponse
     */
    public function responseOk(array $data = []): JsonResponse
    {
        return new JsonResponse(
            array_merge($data, ['status' => 'ok']),
            201
        );
    }

    /**
     * @return JsonResponse
     */
    public function responseDeleted(): JsonResponse
    {
        return new JsonResponse(['status' => 'ok'], 202);
    }
}
