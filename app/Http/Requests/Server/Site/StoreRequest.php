<?php

namespace App\Http\Requests\Server\Site;

use App\Models\Server;
use App\Models\Server\Site;
use App\Validation\Rules\Server\Site\PublicPath;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('store', [Site::class, $this->getServer()]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'domain' => ['required', 'string', Rule::unique('server_sites')],
            'public_dir' => ['required', 'string', new PublicPath()]
        ];
    }

    /**
     * @return Site
     */
    public function persist(): Site
    {
        return $this->getServer()->sites()->create(
            $this->validationData()
        );
    }

    /**
     * @return Server
     */
    protected function getServer(): Server
    {
        return $this->route('server');
    }
}
