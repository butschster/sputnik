<?php

namespace App\Http\Requests\Server\Database;

use App\Models\Server;
use App\Models\Server\Database;
use App\Server\Modules\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

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
            'module_id' => [
                'required',
                'uuid',
                function ($attribute, $id, $fail) {
                    $module = $this->getServer()->modules()->where('id', $id)->first();
                    if (!$module) {
                        $fail('Module not found');
                    }

                    if (!$module->belongsToCategories(['database', 'sql'])) {
                        $fail('Module cant be used for SQL database');
                    }
                },
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
        return $this->getServer()->databases()->create(
            $this->validated()
        );
    }

    /**
     * @return Server
     */
    protected function getServer(): Server
    {
        return $this->route('server');
    }

    /**
     * @return array
     */
    protected function availableDatabaseTypes(): array
    {
        return Collection::forServer($this->getServer())
            ->filterByCategories(['database', 'sql'])
            ->all();
    }
}
