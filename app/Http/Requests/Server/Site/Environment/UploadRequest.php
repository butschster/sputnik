<?php

namespace App\Http\Requests\Server\Site\Environment;

use App\Models\Server\Site;
use Dotenv\Environment\DotenvFactory;
use Dotenv\Exception\InvalidFileException;
use Dotenv\Loader;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UploadRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('update', $this->getSite());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'variables' => 'required|string',
        ];
    }

    /**
     * @param \Illuminate\Validation\Validator $validator
     * @return mixed
     */
    public function withValidator(\Illuminate\Validation\Validator $validator): void
    {
        $validator->after(function ($validator) {
            try {
                $this->parseVariablesString();
            } catch (InvalidFileException $e) {
                $validator->errors()->add('variables', 'File must contain env variables.');
            }
        });
    }

    /**
     * @throws InvalidFileException
     * @return array
     */
    protected function parseVariablesString(): array
    {
        $loader = new Loader([],  new DotenvFactory());
        return $loader->loadDirect($this->variables);
    }

    /**
     * @return Site
     */
    public function persist(): Site
    {
        $site = $this->getSite();

        $data = $this->parseVariablesString();

        $site->update([
            'environment' => $data
        ]);

        return $site;
    }

    /**
     * @return Site
     */
    protected function getSite(): Site
    {
        return $this->route('site');
    }
}
