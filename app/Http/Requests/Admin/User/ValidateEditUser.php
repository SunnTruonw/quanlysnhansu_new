<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class ValidateEditUser extends FormRequest
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
            "slug" => "required",
            "avatar_path" => "mimes:jpeg,jpg,png,svg,webp|nullable|file|max:3000",
            "image_path" => "mimes:jpeg,jpg,png,svg,webp|nullable|file|max:3000",
            "active" => "required",

            "sex" => "required",
            "address" => "required",
            "email" => "required|email|unique:users",
            'phone' => 'required|min:11|numeric',
            "date_working" => "required",
            "date_off" => "nullable",
            "order" => "nullable|numeric",
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên danh mục không được bổ trống',
            'name.max' => 'Tên danh mục không vượt quá 255 ký tự',
            'slug.required' => 'Đường dẫn danh mục không được bổ trống',
            'slug.max' => 'Đường dẫn danh mục không vượt quá 255 ký tự',
            'slug.unique' => 'Đường dẫn đã tồn tại',
            "avatar.mimes" => "Ảnh danh mục có đuôi jpeg,jpg,png,svg,webp",
            "avatar_path.max" => "Ảnh vượt quá size < 3mb",
            "active.required" => "active category is required",
            "sex.required" => "Vui lòng chọn giới tính",
            "address.required" => "Địa chỉ không được bỏ trống",
            "email.required" => "Email không được bỏ trống",
            "phone.required" => "Số điện thoại không được bỏ trống",
            "phone.required" => "Số điện thoại không được bỏ trống",
            "phone.min" => "Số điện thoại không hợp lệ",
            "phone.numeric" => "Số điện thoại không hợp lệ",
            "date_working.required" => "Ngày vào làm không được bỏ trống",
            "order.numeric" => "Số thứ tự không hợp lệ",
        ];
    }
}
