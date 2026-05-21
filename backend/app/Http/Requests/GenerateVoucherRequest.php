<?php

namespace App\Http\Requests;

use App\Services\Aircraft\AircraftLayoutRegistry;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GenerateVoucherRequest extends FormRequest
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
        $supported = app(AircraftLayoutRegistry::class)->supportedTypes();

        return [
            'name'         => ['required', 'string', 'max:100'],
            'id'           => ['required', 'string', 'max:50'],
            'flightNumber' => ['required', 'string', 'regex:/^[A-Z]{2}\d{1,4}$/'],
            'date'         => ['required', 'date_format:Y-m-d'],
            'aircraft'     => ['required', Rule::in($supported)],
        ];
    }

    public function messages(): array
    {
        return [
            'flightNumber.regex' => 'Flight number format is invalid (e.g. GA102).',
            'date.date_format'   => 'Date must be in YYYY-MM-DD format.',
            'aircraft.in'        => 'Aircraft type is not supported.',
        ];
    }
}
