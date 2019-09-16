<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'max:255'],
            'address' => ['nullable', 'string'],
            'lang' => ['required', 'string', Rule::in(config('app.available_locales'))],
        ];
    }

    /**
     * @return User
     */
    public function persist(): User
    {
        $this->user()->update(
            $this->validated()
        );

        return $this->user();
    }
}
