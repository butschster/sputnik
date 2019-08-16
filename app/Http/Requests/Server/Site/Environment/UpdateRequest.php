<?php

namespace App\Http\Requests\Server\Site\Environment;

use App\Models\Server\Site;
use Dotenv\Environment\DotenvFactory;
use Dotenv\Exception\InvalidFileException;
use Dotenv\Loader;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class UpdateRequest extends FormRequest
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
            'key' => 'required|string|alpha_dash',
            'value' => 'required|string'
        ];
    }

    /**
     * @return Site
     */
    public function persist(): Site
    {
        $site = $this->getSite();
        $environment = $site->environment ?? [];

        $environment[$this->key] = $this->value;
        $site->update([
            'environment' => $environment
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
