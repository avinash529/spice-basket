<?php

namespace App\Http\Requests;

use App\Rules\KeralaPhone;
use App\Rules\KeralaPincode;
use App\Support\Kerala;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddressRequest extends FormRequest
{
    protected $errorBag = 'address';

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', new KeralaPhone],
            'house_street' => ['required', 'string', 'max:500'],
            'district' => ['required', 'string', Rule::in(Kerala::DISTRICTS)],
            'pincode' => ['required', 'string', 'size:6', new KeralaPincode],
            'is_default' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'full_name' => trim((string) $this->input('full_name')),
            'phone' => trim((string) $this->input('phone')),
            'house_street' => trim((string) $this->input('house_street')),
            'district' => trim((string) $this->input('district')),
            'pincode' => Kerala::digitsOnly((string) $this->input('pincode')),
            'is_default' => $this->boolean('is_default'),
        ]);
    }
}
