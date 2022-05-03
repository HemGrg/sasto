<?php

namespace Modules\ProductCategory\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],// 'unique:product_categories,name,' . $this->id],
            'slug' => 'nullable|max:255|unique:product_categories,slug,' . $this->id,
            'subcategory_id' => ['required', 'exists:subcategories,id'],
            'is_featured' => 'nullable|boolean',
            'publish' => 'nullable|boolean',
            'image' => 'nullable'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
