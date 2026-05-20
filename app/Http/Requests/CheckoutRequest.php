<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'delivery_recipient_name' => ['required', 'string', 'max:255'],
            'delivery_phone' => ['required', 'string', 'max:50'],
            'delivery_address_detail' => ['required', 'string', 'max:1000'],
            'delivery_note' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'string', 'in:cash,credit_card'],
            'scheduled_delivery_time' => ['nullable', 'date'],
        ];
    }
}
