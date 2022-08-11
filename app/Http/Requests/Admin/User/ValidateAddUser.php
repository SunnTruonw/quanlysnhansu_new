<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ValidateAddUser extends FormRequest
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
        $rules =  [
            'name' => 'required|max:255',
            "avatar_path" => "mimes:jpeg,jpg,png,svg,webp|nullable|file|max:3000",
            "image_path" => "mimes:jpeg,jpg,png,svg,webp|nullable|file|max:3000",
            "file" => "nullable|file|max:3000",
            "active" => "required",
            "sex" => "required",
            "address" => "required",
            'email' => 'required', 'string', 'email', 'max:255',
            'password'         => 'required|min:8',
            'confirm-password' => 'required|same:password',
            'phone' => 'required',
            "date_working" => "required",
            "date_off" => "nullable",
            "order" => "nullable|numeric",
            'district_id' => 'required',
            'city_id' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên nhân viên không được bổ trống',
            'name.max' => 'Tên nhân viên không vượt quá 255 ký tự',
            'password.required' => 'Mật khẩu không được bổ trống',
            'password.min' => 'Mật khẩu có ít nhất 8 kí tự',
            'confirm-password.required' => 'Vui lòng nhập lại mật khẩu',
            'confirm-password.same' => 'Nhập lại mật khẩu không khớp',
            "avatar_path.mimes" => "Ảnh có đuôi jpeg,jpg,png,svg,webp",
            "avatar_path.max" => "Ảnh vượt quá size < 3mb",
            "image_path.mimes" => "Ảnh có đuôi jpeg,jpg,png,svg,webp",
            "image_path.max" => "Ảnh vượt quá size < 3mb",
            "file.max" => "Ảnh vượt quá size < 3mb",
            "active.required" => "active category is required",
            "sex.required" => "Vui lòng chọn giới tính",
            "address.required" => "Địa chỉ không được bỏ trống",
            "email.required" => "Email không được bỏ trống",
            "phone.required" => "Số điện thoại không được bỏ trống",
            // "phone.required" => "Số điện thoại không được bỏ trống",
            // "phone.min" => "Số điện thoại không hợp lệ",
            "phone.numeric" => "Số điện thoại không hợp lệ",
            "date_working.required" => "Ngày vào làm không được bỏ trống",
            "order.numeric" => "Số thứ tự không hợp lệ",
            'city_id.required' => 'Vui lòng chọn Tỉnh/thành phố',
            'district_id.required' => 'Vui lòng chọn Quận/huyện',

        ];
    }
}
