<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class JsonObject implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $decoded = json_decode($value);

        if (!is_object($decoded)) {
            $fail('The :attribute must be a valid JSON object.');
        }
    }
}
