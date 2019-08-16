<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return UserResource
     */
    public function profile(Request $request): UserResource
    {
        return UserResource::make($request->user());
    }
}
