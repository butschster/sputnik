<?php

namespace Module\Mysql\Http\Requests\Database;

use App\Models\Server;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Module\Mysql\Models\Database;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('store', [Database::class, $this->getServer()]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'alpha_dash',
                Rule::unique('server_databases')->where('server_id', $this->route('server')->id),
            ],
            'password' => [
                'nullable',
                'string',
            ],
        ];
    }

    /**
     * @return Database
     */
    public function persist(): Database
    {
        $database = new Database($this->validated());
        $database->server()->associate($this->getServer());
        $database->save();

        return $$database;
    }

    /**
     * @return Server
     */
    protected function getServer(): Server
    {
        return $this->route('server');
    }
}
