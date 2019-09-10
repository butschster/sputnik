<?php

namespace App\Http\Requests\Server;

use App\Models\Server;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class SearchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'query' => 'required|string',
        ];
    }

    /**
     * @return Collection
     */
    public function search()
    {
        return Server::search($this->query)->with([
            'filters' => 'user_id:'.$this->user()->id,
        ])->get();
    }
}
