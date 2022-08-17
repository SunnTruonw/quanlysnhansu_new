<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ValidateContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'phone'=>'required',
            'message' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được bổ trống',
            'email.required' => 'Email không được bổ trống',
            'phone.required' => 'Số điện thoại không được bổ trống',
            'messages.required' => 'Nội dung không được bổ trống',
        ];
    }
}
