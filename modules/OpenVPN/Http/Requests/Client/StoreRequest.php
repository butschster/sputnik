<?php

namespace Module\OpenVPN\Http\Requests\Client;

use App\Models\Server;
use Domain\Record\Repositories\RecordRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Module\OpenVPN\Models\Client;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('store', [Server\Record::class, $this->getServer()]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $server = $this->getServer();

        return [
            'name' => [
                'required',
                'string',
                'alpha_dash',
                Rule::unique('server_records', 'meta->name')
                    ->where('server_id', $server->id)
                    ->where('module_id', $server->getModule('openvpn')->id)
                    ->where('key', 'client'),
            ],
        ];
    }

    /**
     * @return Server\Record
     */
    public function persist(): Server\Record
    {
        $repository = new RecordRepository();

        return $repository->store(
            $this->getServer(),
            new Client($this->validated())
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
