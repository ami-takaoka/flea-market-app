<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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

            'name' => [
                'required',
                'max:255',
            ],

            'postal_code' => [
                'required',
                'regex:/^\d{3}-\d{4}$/',
            ],

            'address' => [
                'required',
                'max:255',
            ],

            'building' => [
                'nullable',
                'max:255',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png',
            ],
        ];
    }

    public function messages(): array
    {
        return [

            'name.required' => 'ユーザー名を入力してください',
            'name.max' => 'ユーザー名は255文字以内で入力してください',

            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex' => '郵便番号は123-4567形式で入力してください',

            'address.required' => '住所を入力してください',
            'address.max' => '住所は255文字以内で入力してください',

            'building.max' => '建物名は255文字以内で入力してください',

            'image.image' => '画像ファイルを選択してください',
            'image.mimes' => 'JPEGまたはPNG形式でアップロードしてください',
        ];
    }
}