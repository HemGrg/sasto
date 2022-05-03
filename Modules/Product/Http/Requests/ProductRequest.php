<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                => 'sometimes|exists:products,id',
            'title'             => 'required|string',
            'product_category_id' => 'required|numeric|exists:product_categories,id',
            'shipping_charge'   => 'nullable|numeric',
            'unit'              => 'nullable|string',
            'highlight'         => 'nullable',
            'description'       => 'nullable',
            'image'             => $this->updateMode() ? 'nullable|max:2048' : 'required|max:2048',
            'video_link'        => 'nullable|url',
            'is_top'            => 'nullable|boolean',
            'is_new_arrival'    => 'nullable|boolean',
            // 'status'            => 'nullable|in:active,inactive',

            'payment_mode'  => 'nullable|string',
            'country_of_origin'  => 'nullable|string',
            'color'  => 'nullable|string',
            'size'  => 'nullable|string',
            'warranty'  => 'nullable|string',
            'brand'  => 'nullable|string',
            'feature'  => 'nullable|string',
            'use'  => 'nullable|string',
            'gender'  => 'nullable|string',
            'age_group'  => 'nullable|string',

            'meta_title'        => 'nullable|string|max:200',
            'meta_description'  => 'nullable|string',
            'keyword'           => 'nullable|string|max:200',
            'meta_keyphrase'    => 'nullable|string|max:200',
        ];
    }

    public function updateMode()
    {
        return $this->has('id') ? true : false;
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
