<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJsonRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => 'required|integer',
            'code' => [
                'required',
                'regex:/^(\$data(->\w+|\[\'\w+\'\]|\[\d+\])+)\s*=\s*([\w\W]*)$/'
            ]
        ];
    }

    public function messages()
    {
        return [
            'code.regex' => 'The :attribute field must contain a valid JSON manipulation code, starting with "$data->". Example: $data->list->sublist[0] = 0;'
        ];
    }
}
