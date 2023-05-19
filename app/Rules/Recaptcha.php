<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Validation\ValidationRule;

class Recaptcha implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = array(
            'secret' => config('extra.recaptcha_secret'),
            'response' => $value
        );

        $response = Http::withoutVerifying()->post('https://www.google.com/recaptcha/api/siteverify?' . http_build_query($data));
        $result = $response->json();

        if ($result['success'] === false || $result['score'] < 0.3) {
            $fail('validation.recaptcha')->translate();
        }
    }
}
