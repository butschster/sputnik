<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    /**
     * @return JsonResponse
     */
    public function responseDeleted(): JsonResponse
    {
        return new JsonResponse('', 202);
    }
}
