<?php

namespace App\Rules;

use App\Support\Kerala;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class KeralaPhone implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! Kerala::isValidPhone($value)) {
            $fail('The :attribute must be a valid Kerala phone number.');
        }
    }
}
