<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ValidateAddCategory extends FormRequest
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
            "slug" => "nullable|unique:App\Models\Category,slug",
            "avatar_path" => "mimes:jpeg,jpg,png,svg,webp|nullable|file|max:3000",
            "active" => "required",
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
        ];
    }
}
