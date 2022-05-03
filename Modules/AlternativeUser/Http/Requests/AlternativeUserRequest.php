<?php

namespace Modules\AlternativeUser\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlternativeUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:alternative_users,email,' . $this->id . '|unique:users,email',
            'mobile' => 'required',
            'password' => $this->updateMode() ? ['nullable'] : ['required'],
            'permissions' => 'nullable',
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
    
    protected function updateMode() {
        return $this->filled('id');
    }
}
