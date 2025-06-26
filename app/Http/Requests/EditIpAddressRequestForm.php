<?php

namespace App\Http\Requests;

use App\Models\IpAddress;
use Illuminate\Foundation\Http\FormRequest;

class EditIpAddressRequestForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $ip_address = IpAddress::find($this->route('ip_address'));
        
        if ($this->user()->hasRole('super_admin')) {
            return true;
        } else {
            return $ip_address && $this->user()->can('update-ip_address', $ip_address);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'label' => 'string|required',
        ];
    }
}
