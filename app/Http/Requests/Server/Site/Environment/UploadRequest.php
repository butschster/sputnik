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
            'file' => 'required|file',
        ];
    }

    /**
     * @return Site
     */
    public function persist(): Site
    {
        $site = $this->getSite();
        $loader = new Loader([],  new DotenvFactory());

        try {
            $data = $loader->loadDirect(
                file_get_contents($this->file('file')->openFile()->getRealPath())
            );
        } catch (InvalidFileException $e) {
            return $site;
        }

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
