<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\Controller;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Resources\v1\UserProfileResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param Request $request
     *
     * @return UserProfileResource
     */
    public function profile(Request $request): UserProfileResource
    {
        return UserProfileResource::make(
            $request->user()
        );
    }

    /**
     * @param UpdateRequest $request
     *
     * @return UserProfileResource
     */
    public function update(UpdateRequest $request): UserProfileResource
    {
        return UserProfileResource::make(
            $request->persist()
        );
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function delete(Request $request)
    {
        $this->validate($request, [
            'email' => ['required', 'email', function ($attribute, $value, $fail) use ($request) {
                if ($value != $request->user()->email) {
                    $fail('Email address is not correct.');
                }
            }],
        ]);

        return $this->responseDeleted();
    }
}
