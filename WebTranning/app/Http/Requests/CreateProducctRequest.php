<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProducctRequest extends FormRequest
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
            'product_name' => 'required|min:5',
            'product_price' => 'required|numeric|gt:0',
            'is_sales' => 'required',
            'product_image' => 'mimes:jpeg,jpg,png|max:2048|dimensions:max_width=1024',

        ];
    }
    public function messages()
    {
        return [
            'product_name.required' => 'Vui lòng nhập tên sản phẩm',
            'product_name.min' => 'Tên phải lớn hơn 5 ký tự',

            'product_price.required' => 'Giá bán không được để trống.',
            'product_price.numeric' => 'Giá bán chỉ được nhập số',
            'product_price.gt' => 'Giá bán không được nhỏ hơn 0',

            'is_sales.required' => 'Trạng thái không được để trống',
            'product_image.mimes' => 'Chỉ được định dạng .png, .jpg, .jpeg',
            'product_image.max' => 'Dung lương không quá 2 MB',
            'product_image.dimensions' => 'Kích thước không quá 1024px.'

        ];
    }
}
