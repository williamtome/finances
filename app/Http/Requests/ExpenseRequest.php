<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'nullable|integer|exists:categories,id',
            'description' => 'required|string|min:5',
            'amount' => 'required|numeric|gte:1',
        ];
    }

    protected function passedValidation(): void
    {
        if (is_null($this->category_id)) {
            $this->merge([
                'category_id' => Category::OTHERS,
            ]);
        }
    }
}
