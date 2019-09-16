<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Subscription\Plan;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project_name' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'max:255'],
            'address' => ['nullable', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * @return User
     * @throws \Throwable
     */
    public function persist(): User
    {
        return DB::transaction(function () {

            $data = $this->validated();

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'company' => $data['company'] ?? null,
                'address' => $data['address'] ?? null,
                'password' => Hash::make($data['password']),
            ]);

            $team = User\Team::create([
                'name' => $data['project_name'],
                'owner_id' => $user->id
            ]);

            $owner = User\Role::where('name', 'owner')->firstOrFail();
            $user->attachRole($owner, $team);

            $team->subscribeTo(
                Plan::findByName('free')
            );

            return $user;
        });
    }
}
