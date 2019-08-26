<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\Controller;
use App\Http\Resources\v1\UserProfileResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return UserProfileResource
     */
    public function profile(Request $request): UserProfileResource
    {
        return UserProfileResource::make($request->user());
    }
}
