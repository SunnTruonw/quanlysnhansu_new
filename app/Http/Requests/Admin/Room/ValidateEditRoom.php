<?php

namespace App\Http\Requests\Admin\Room;

use Illuminate\Foundation\Http\FormRequest;

class ValidateEditRoom extends FormRequest
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
            'name' => 'required|max:255',
            "order" => "nullable|numeric",
            "avatar_path" => "mimes:jpeg,jpg,png,svg,webp|nullable|file|max:3000",
            "active" => "required",
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên danh mục không được bổ trống',
            'name.max' => 'Tên danh mục không vượt quá 255 ký tự',
            "avatar.mimes" => "Ảnh danh mục có đuôi jpeg,jpg,png,svg,webp",
            "avatar_path.max" => "Ảnh vượt quá size < 3mb",
            "active.required" => "active category is required",
        ];
    }
}
