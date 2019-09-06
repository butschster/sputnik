<?php

namespace App\Http\Requests\Server\Site;

use App\Models\Server\Site;
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
        return Site::search($this->query)->with([
            'filters' => 'user_id:'.$this->user()->id,
        ])->get();
    }
}
