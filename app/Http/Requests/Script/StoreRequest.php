<?php

namespace App\Http\Requests\Script;

use App\Models\Script;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', Script::class);
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', Rule::unique('scripts')],
            'description' => 'nullable|string',
            'public' => 'required|boolean',
            'multiple_execution' => 'required|boolean',
            'script' => 'required|string',
        ];
    }

    /**
     * @return Script
     */
    public function persist(): Script
    {
        return $this->user()->scripts()->create(
            $this->validated()
        );
    }
}
