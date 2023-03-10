<?php

namespace App\Http\Requests;

use App\Rules\JsonObject;
use Illuminate\Foundation\Http\FormRequest;

class StoreJsonRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'json' => ['required', new JsonObject]
        ];
    }
}
