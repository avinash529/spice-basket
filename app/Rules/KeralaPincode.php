<?php

namespace App\Rules;

use App\Support\Kerala;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class KeralaPincode implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! Kerala::isValidPincode($value)) {
            $fail('The :attribute must be a valid Kerala pincode.');
        }
    }
}
