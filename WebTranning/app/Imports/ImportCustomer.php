<?php

namespace App\Imports;

use App\Models\MstCustomer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;



class ImportCustomer implements ToModel, WithHeadingRow, WithValidation,SkipsOnFailure
{
    use  Importable,SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new MstCustomer([
            'customer_name'     => $row['name'],
            'email'    => $row['email'],
            'tel_num'    => $row['phone'],
            'address'    => $row['address'],
        ]);
    }
    // public function startRow(): int
    // {
    //     return 2;
    // }
    public function rules(): array
    {
        return [
            'name' => 'required|min:5',
            '*.name' => 'required|min:5',

            'email' => 'required|email|unique:mst_customer,email',
            '*.email' => 'required|email|unique:mst_customer,email',

            'phone' => 'required|regex:/(09)[0-9]{9}/',
            '*.phone' => 'required|regex:/(09)[0-9]{9}/',

            'address' => 'required',
            '*.address' => 'required',
        ];
    }
    public function customValidationMessages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên khách hàng',
            'name.min' => 'Tên khách hàng phải lớn hơn 5 ký tự',

            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được đăng ký',

            'phone.required' => 'Điện thoại không được để trống',
            'phone.regex' => 'Nhập không đúng định dạng điện thoại',

            'address.required' => 'Địa chỉ không được để trống',
        ];
    }
}
