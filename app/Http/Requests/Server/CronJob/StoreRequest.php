<?php

namespace App\Http\Requests\Server\CronJob;

use App\Http\Requests\SanitizesInput;
use App\Models\Server\CronJob;
use App\Validation\Rules\Server\CronExpression;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    use SanitizesInput;

    /**
     *  Filters to be applied to the input.
     * @return void
     */
    public function filters()
    {
        return [
            'cron' => 'strip_tags|lowercase|cron',
            'command' => 'strip_tags',
            'name' => 'strip_tags',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string',
            'cron' => ['required', 'string', new CronExpression()],
            'command' => 'required|string',
            'user' => 'required|string',
        ];
    }

    /**
     * @return CronJob
     */
    public function persist(): CronJob
    {
        $server = $this->route('server');

        $data = $this->validationData();

        return $server->cronJobs()->create($data);
    }
}
