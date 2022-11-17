<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name' => 'required|min:5',
            'email' => 'required|email|unique:mst_users,email',
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'same:password',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên người sử dụng',
            'name.min' => 'Tên phải lớn hơn 5 ký tự',

            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được đăng ký',

            'password.required' => 'Mật khẩu không được trống',
            'password.min' => 'Mật khẩu phải hơn 5 ký tự',
            'password.confirmed' => 'Mật khẩu và xác nhận mật khẩu không chính xác.',

        ];
    }
}
