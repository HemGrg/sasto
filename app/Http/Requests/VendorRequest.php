<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Mobile;

class VendorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
        'email' => 'required|email|unique:users',
        'name' => 'required',
        'designation' => 'required',
        'phone_num' => ['required', new Mobile],
        'password' => 'required|min:6',
        'confirm_password' => 'required_with:password|same:password'
        ];
    }
}
