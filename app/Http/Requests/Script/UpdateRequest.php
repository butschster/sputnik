<?php

namespace App\Http\Requests\Script;

use App\Models\Script;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('update', $this->getScript());
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', Rule::unique('scripts')->ignore($this->getScript()->id)],
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
        $this->getScript()->update(
            $this->validated()
        );

        return $this->getScript();
    }

    /**
     * @return Script
     */
    protected function getScript(): Script
    {
        return $this->route('script');
    }
}
