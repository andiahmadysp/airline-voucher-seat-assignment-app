<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckVoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'flightNumber' => ['required', 'string', 'regex:/^[A-Z]{2}\d{1,4}$/'],
            'date'         => ['required', 'date_format:Y-m-d'],
        ];
    }

    public function messages(): array
    {
        return [
            'flightNumber.regex' => 'Flight number format is invalid (e.g. GA102).',
            'date.date_format'   => 'Date must be in YYYY-MM-DD format.',
        ];
    }
}
