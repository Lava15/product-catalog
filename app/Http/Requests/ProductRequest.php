<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('id');

        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'price' => ['required', 'numeric', 'between:0,99999999.99'],
            'barcode' => [ 'nullable', 'string', 'regex:/^\d{13}$/',
                Rule::unique(table: 'products', column: 'barcode')->ignore(id: $productId),
            ],
            'category_id' => ['nullable', 'exists:categories,id'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Название обязательно.',
            'name.min' => 'Название должно содержать минимум 2 символа.',
            'price.required' => 'Цена обязательна.',
            'price.numeric' => 'Цена должна быть числом.',
            'price.between' => 'Цена должна быть от 0 до 99,999,999.99.',
            'barcode.regex' => 'Штрихкод должен содержать ровно 13 цифр (формат EAN-13).',
            'barcode.unique' => 'Такой штрихкод уже используется другим товаром.',
            'category_id.exists' => 'Выбранная категория не существует.',
        ];
    }
}
