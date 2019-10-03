<?php

namespace Module\Scheduler\Http\Requests\CronJob;

use App\Http\Requests\Sanitizer\SanitizesInput;
use App\Models\Server;
use App\Validation\Rules\Server\CronExpression;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Module\Scheduler\Models\CronJob;

class StoreRequest extends FormRequest
{
    use SanitizesInput;

    public function authorize()
    {
        return Gate::allows('store', [CronJob::class, $this->getServer()]);
    }

    /**
     * Filters to be applied to the input.
     * @return array
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
        $job = new CronJob($this->validated());
        $job->server()->associate($this->getServer());
        $job->save();

        return $job;
    }

    /**
     * @return Server
     */
    protected function getServer(): Server
    {
        return $this->route('server');
    }
}
