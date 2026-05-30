<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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

            'image' => [
                'required',
                'image',
                'mimes:jpeg,png',
            ],

            'categories' => [
                'required',
                'array',
            ],

            'condition' => [
                'required',
            ],

            'name' => [
                'required',
                'max:255',
            ],

            'description' => [
                'required',
                'max:255',
            ],

            'price' => [
                'required',
                'integer',
                'min:0',
            ],
        ];
    }

    public function messages(): array
    {
        return [

            'image.required' => '商品画像を選択してください',
            'image.image' => '画像ファイルを選択してください',
            'image.mimes' => 'JPEGまたはPNG形式でアップロードしてください',

            'categories.required' => 'カテゴリーを選択してください',

            'condition.required' => '商品の状態を選択してください',

            'name.required' => '商品名を入力してください',
            'name.max' => '商品名は255文字以内で入力してください',

            'description.required' => '商品説明を入力してください',
            'description.max' => '商品説明は255文字以内で入力してください',

            'price.required' => '販売価格を入力してください',
            'price.integer' => '販売価格は数字で入力してください',
            'price.min' => '販売価格は0円以上で入力してください',
        ];
    }
}