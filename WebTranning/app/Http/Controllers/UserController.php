<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\MstUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login()
    {
        $fail = false;
        return View('login', compact('fail'));
    }
    public function store(LoginRequest $request)
    {
        $remember = $request->rememberCheck == 1 ? true : false;
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            $user = MstUsers::find(Auth::id());
            $user->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $request->getClientIp()
            ]);
            return redirect()->route('list-product');
        } else {
            $fail = true;
            return View('login', compact('fail'));
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
    function authenticated(Request $request, $user)
    {
        $user->last_login = Carbon::now()->toDateTimeString();
        $user->last_login_ip = $request->getClientIp();
        $user->save();
    }

    public function index()
    {
        //$listProduct=MstProduct::all();
        $listUser = MstUsers::Where('is_delete', "0")->orderBy('updated_at', 'desc')->paginate(20);
        return View('Users/home', ['listUser' => $listUser]);
    }

    public function fetchData(Request $request)
    {
        if ($request->ajax()) {
            // $listProduct = MstProduct::orderBy('created_at','desc')->paginate(25);
            $listUser = MstUsers::Where('is_delete', "0")->Where(function ($q) use ($request) {
                $q->when($request->filled('name'), function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->name . '%');
                })->when($request->filled('email'), function ($q) use ($request) {
                    $q->where('email', 'LIKE', '%' . $request->email . '%');
                })
                    ->when($request->filled('group_role'), function ($q) use ($request) {
                        $q->where('group_role', $request->group_role);
                    })
                    ->when($request->filled('is_active'), function ($q) use ($request) {
                        $q->where('is_active', $request->is_active);
                    });
            })->orderBy('updated_at', 'desc')->paginate(20)->appends($request->except(['page', '_token']));
            return View('Users/user-data', ['listUser' => $listUser])->render();
        }
    }

    public function storeAdd(Request $request)
    {
        $messages = [
            'name.required' => 'Vui l??ng nh???p t??n ng?????i s??? d???ng',
            'name.min' => 'T??n ph???i l???n h??n 5 k?? t???',

            'email.required' => 'Email kh??ng ???????c ????? tr???ng',
            'email.email' => 'Email kh??ng ????ng ?????nh d???ng',
            'email.unique' => 'Email ???? ???????c ????ng k??',

            'password.required' => 'M???t kh???u kh??ng ???????c tr???ng',
            'password.min' => 'M???t kh???u ph???i h??n 5 k?? t???',
            'password.regex'=>'M???t kh???u kh??ng b???o m???t',
            'password_confirmation.same' => 'M???t kh???u v?? x??c nh???n m???t kh???u kh??ng ch??nh x??c.',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:mst_users,email',
            'password' => [
                'required',
                'string',
                'min:5',             
                'regex:/[a-z]/',      
                'regex:/[A-Z]/',     
                'regex:/[0-9]/',   
            ],
            'password_confirmation' => 'same:password',
        ], $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'errors',
                'message' => $validator->errors()->all(),
            ]);
        }
        $user = new MstUsers();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->group_role = $request->group_role;
        $user->is_active = $request->is_active == 1 ? 1 : 0;;

        $user->save();
        // return response()->json(['success'=>'Th??m th??nh c??ng']);
        return response()->json([
            'status' => 'success',
            'message' => 'Th??m th??nh c??ng',
        ]);
    }
    public function storeEdit(Request $request)
    {
        $user = MstUsers::find($request->id);
        $messages = [
            'name.required' => 'Vui l??ng nh???p t??n ng?????i s??? d???ng',
            'name.min' => 'T??n ph???i l???n h??n 5 k?? t???',

            'email.required' => 'Email kh??ng ???????c ????? tr???ng',
            'email.email' => 'Email kh??ng ????ng ?????nh d???ng',
            'email.unique' => 'Email ???? ???????c ????ng k??',

            'password.required' => 'M???t kh???u kh??ng ???????c tr???ng',
            'password.min' => 'M???t kh???u ph???i h??n 5 k?? t???',
            'password.regex'=>'M???t kh???u kh??ng b???o m???t',
            'password_confirmation.same' => 'M???t kh???u v?? x??c nh???n m???t kh???u kh??ng ch??nh x??c.',
        ];
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:mst_users,email,' . $user->id,
            'password' => [
                'required',
                'string',
                'min:5',             
                'regex:/[a-z]/',      
                'regex:/[A-Z]/',     
                'regex:/[0-9]/',   
            ],
            'password_confirmation' => 'same:password',
        ], $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'errors',
                'message' => $validator->errors()->all(),
            ]);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->group_role = $request->group_role;
        $user->is_active = $request->is_active == 1 ? 1 : 0;
        $user->save();
        // return response()->json(['success'=>'Th??m th??nh c??ng']);
        return response()->json([
            'status' => 'success',
            'message' => 'S???a th??nh c??ng',
        ]);
    }
    public function storeDelete($id)
    {
        $user = MstUsers::find($id);
        $user->is_delete = 1;
        $user->save();
        return response()->json([
            'status' => 'success',
            'message' => 'X??a th??nh c??ng',
        ], 200);
    }
    public function storeLock($id)
    {
        $user = MstUsers::find($id);
        $str = $user->is_active == 1 ? "Kh??a" : "M??? kh??a";
        $user->is_active = $user->is_active == 1 ? 0 : 1;
        $user->save();
        return response()->json([
            'status' => 'success',
            'message' => $str . ' th??nh c??ng',
        ], 200);
    }
}
