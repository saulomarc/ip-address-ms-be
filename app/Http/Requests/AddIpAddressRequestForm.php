<?php

namespace App\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class AddIpAddressRequestForm extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ip_address' => [
                'string',
                'required', 
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!filter_var($value, FILTER_VALIDATE_IP, [FILTER_FLAG_IPV4, FILTER_FLAG_IPV6])) {
                        $fail("Invalid format of {$attribute}");
                    }
                }
            ],
            'label' => 'string|required',
        ];
    }
}
