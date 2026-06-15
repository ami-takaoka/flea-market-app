<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [

            'payment_method' => [
                'required',
                'in:1,2',
            ],

            'postal_code' => [
                'required',
            ],

            'address' => [
                'required',
            ],
        ];
    }

    public function messages(): array
    {
        return [

            'payment_method.required' => '支払い方法を選択してください',
            'payment_method.in' => '支払い方法を選択してください',
            'postal_code.required' => '配送先を入力してください',
            'address.required' => '配送先を入力してください',
        ];
    }
}