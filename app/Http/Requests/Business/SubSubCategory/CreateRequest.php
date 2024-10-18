<?php

namespace App\Http\Requests\Business\SubSubCategory;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:100',
            'business_type' => 'required|integer|max:250',
            'category_id' => 'required|integer|max:250',
            // 'sub_category_id' => 'required|integer|max:250',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Title is required!',
            'business_type.required' => 'Business Type is required!',
            'category_id.required' => 'Category is required!',
            // 'sub_category_id.required' => 'Sub Category is required!',
        ];
    }
}
