<?php

namespace App\Http\Requests\Server\Site\Environment;

use App\Models\Server\Site;
use Dotenv\Environment\DotenvFactory;
use Dotenv\Exception\InvalidFileException;
use Dotenv\Loader;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DeleteRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('deploy', $this->getSite());
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
        ];
    }

    /**
     * @return Site
     */
    public function persist(): Site
    {
        $site = $this->getSite();

        $environment = $site->environment ?? [];
        unset($environment[$this->key]);

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
