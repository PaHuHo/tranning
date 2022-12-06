<?php

namespace App\Http\Controllers;

use App\Exports\ExportCustomer;
use App\Imports\ImportCustomer;
use App\Models\MstCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use MeiliSearch\Client;
use MeiliSearch\Endpoints\Indexes;

class CustomerController extends Controller
{
    public function index()
    {
        $client = new Client('http://localhost:7700', 'masterKey');
        $client->index('mst_customer')->updateSortableAttributes([
            'updated_at',
        ]);
        $client->index('mst_customer')->updateFilterableAttributes(['email', 'is_active', 'address']);
        $client->index('mst_customer')->updateSearchableAttributes([
            'customer_name',
        ]);

        $listCustomer = MstCustomer::orderBy('updated_at', 'desc')->paginate(20);

        return View('Customer/home', ['listCustomer' => $listCustomer]);
    }
    public function fetchData(Request $request)
    {
        if ($request->ajax()) {
            // $listProduct = MstProduct::orderBy('created_at','desc')->paginate(25);
            // $listCustomer = MstCustomer::Where(function ($q) use ($request) {
            //     $q->when($request->filled('name'), function ($q) use ($request) {
            //         $q->where('customer_name', 'LIKE', '%' . $request->name . '%');
            //     })->when($request->filled('email'), function ($q) use ($request) {
            //         $q->where('email', 'LIKE', '%' . $request->email . '%');
            //     })
            //         ->when($request->filled('is_active'), function ($q) use ($request) {
            //             $q->where('is_active', $request->is_active);
            //         })
            //         ->when($request->filled('address'), function ($q) use ($request) {
            //             $q->where('address', 'LIKE', '%' . $request->address . '%');
            //         });
            // })->orderBy('updated_at', 'desc')->paginate(20)->appends($request->except(['page', '_token']));


            //dd($client->index('mst_customer')->search($request->name,['sort' => ['updated_at:desc']]));
            // $listCustomer=$client->index('mst_customer')->search($request->name,['sort' => ['price:desc']])->paginate(20)->appends($request->except(['page', '_token']));
            
            $listCustomer = MstCustomer::search("  ", function ($index, $query, $options) use ($request) {
                $client = new Client('http://localhost:7700', 'masterKey');
                $options['sort']=['updated_at:desc'];
                if (isset($request->name)) {
                    $client->index('mst_customer')->updateSearchableAttributes([
                        'customer_name',
                    ]);
                    if (isset($request->is_active)) {
                        $options['filter'] = "(is_active =" . $request->is_active . ")";
                    }
                    return $index->search($request->name, $options);
                }
                
                if (isset($request->is_active)) {
                    $options['filter'] = "(is_active =" . $request->is_active . ")";
                }
                
                return $index->search($query, $options);
            })->paginate(20)->appends($request->except(['page', '_token']));            
            return View('Customer/customer-data', ['listCustomer' => $listCustomer])->render();
        }
    }
    public function storeAdd(Request $request)
    {
        $messages = [
            'name.required' => 'Vui lòng nhập tên khách hàng',
            'name.min' => 'Tên khách hàng phải lớn hơn 5 ký tự',

            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được đăng ký',

            'phone.required' => 'Điện thoại không được để trống',
            'phone.regex' => 'Nhập không đúng định dạng điện thoại',
            'phone.max' => 'Nhập không đúng định dạng điện thoại',
            'address.required' => 'Địa chỉ không được để trống',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:mst_customer,email',
            'phone' => 'required|regex:/(09)[0-9]{9}/|max:11',
            'address' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'errors',
                'message' => $validator->errors()->all(),
            ]);
        }
        $customer = new MstCustomer();
        $customer->customer_name = $request->name;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->tel_num = $request->phone;
        $customer->is_active = $request->is_active == 1 ? 1 : 0;
        $customer->save();
        // return response()->json(['success'=>'Thêm thành công']);
        return response()->json([
            'status' => 'success',
            'message' => 'Thêm thành công',
        ]);
    }

    public function storeEdit(Request $request)
    {
        $customer = MstCustomer::where('customer_id', $request->id)->first();
        if ($request->action == "delete") {

            // $customer->update(array(
            //     'is_active' => 0,
            // ));
            $customer->is_active = 0;
            $customer->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Xóa thành công',
            ]);
        }
        $messages = [
            'name.required' => 'Vui lòng nhập tên khách hàng',
            'name.min' => 'Tên khách hàng phải lớn hơn 5 ký tự',

            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được đăng ký',

            'phone.required' => 'Điện thoại không được để trống',
            'phone.regex' => 'Nhập không đúng định dạng điện thoại',
            'phone.max' => 'Nhập không đúng định dạng điện thoại',
            'address.required' => 'Địa chỉ không được để trống',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:mst_customer,email,' . $customer->customer_id . ',customer_id',
            'phone' => 'required|regex:/(09)[0-9]{9}/|max:11',
            'address' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'errors',
                'message' => $validator->errors()->all(),
            ]);
        }
        // $customer->update(array(
        //     'customer_name' => $request->name,
        //     'email' => $request->email,
        //     'address' => $request->address,
        //     'tel_num' => $request->phone,
        //     'is_active' => $request->is_active == 1 ? 1 : 0,
        // ));

        $customer->customer_name = $request->name;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->tel_num = $request->phone;
        $customer->is_active = $request->is_active == 1 ? 1 : 0;
        $customer->save();

        // return response()->json(['success'=>'Thêm thành công']);
        return response()->json([
            'status' => 'success',
            'message' => 'Sửa thành công',
        ]);
    }
    public function export(Request $request)
    {
        $listCustomer = null;
        if (!$request->filled('name') && !$request->filled('email') && !$request->filled('is_active') && !$request->filled('address')) {
            $listCustomer = MstCustomer::select('customer_name', 'email', 'tel_num', "address")->orderBy('updated_at', 'desc')->skip(0)->take(20)->get();
        } else {
            $listCustomer = MstCustomer::select('customer_name', 'email', 'tel_num', "address")->Where(function ($q) use ($request) {
                $q->when($request->filled('name'), function ($q) use ($request) {
                    $q->where('customer_name', 'LIKE', '%' . $request->name . '%');
                })->when($request->filled('email'), function ($q) use ($request) {
                    $q->where('email', 'LIKE', '%' . $request->email . '%');
                })
                    ->when($request->filled('is_active'), function ($q) use ($request) {
                        $q->where('is_active', $request->is_active);
                    })
                    ->when($request->filled('address'), function ($q) use ($request) {
                        $q->where('address', 'LIKE', '%' . $request->address . '%');
                    });
            })->orderBy('updated_at', 'desc')->get();
        }
        if ($listCustomer->count() == 0) {
            return redirect()->back()->with('fail-export', 'Không có dữ liệu để export');
        }
        return Excel::download(new ExportCustomer($listCustomer), 'customer-' . time() . '.xls');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function import(Request $request)
    {
        $messages = [
            'file.required' => 'Vui lòng import file',
            'file.mimes' => 'Không đúng định dạng file ',
        ];
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv',
        ], $messages);
        if ($validator->fails()) {
            $validator->errors()->add('faile', 'This is the error message');
            throw new \Illuminate\Validation\ValidationException($validator);
        }
        try {
            // Excel::import(new ImportCustomer, $request->file);
            $import = new ImportCustomer();
            $import->import($request->file);
            if (empty($import->failures())) {
                return redirect()->back()->with('success', 'Import thành công');
            } else {
                return redirect()->back()->with('import-errors', $import->failures());
            }
        } catch (ValidationException $e) {
            $failures = $e->failures();
            return response()->json([
                'status' => 'import-erros',
                'message' => $failures,
            ]);
        }
    }
}
