<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showFormRegister(){
        $title = 'Đăng ký tài khoản';
        $categories = Category::where('active', 1) -> where('parent_id', 0) -> orderByDesc('id') -> get();
        return view('customer.formRegister', compact('title', 'categories'));
    }

    public function register(Request $request){
        $request -> validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users,email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i',
            'password' => 'required|confirmed|min:6|max:50'
        ],
        [
            'name.required' => 'Tên người dùng không được để trống',
            'email.required' => 'Email không được để trống',
            'email.regex' => 'Email không hợp lệ',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            'password.confirmed' => 'Xác nhận mật khẩu không hợp lệ',
            'password.min' => 'Mật khẩu ít nhất phải 6 ký tự', 
            'password.max' => 'Mật khẩu tối đa 50 ký tự', 
        ]);
        try{
            $user = User::create([
                'name' => $request -> name,
                'email' => $request -> email,
                'password' => Hash::make($request -> password)
            ]);
            if($user){
                Session::flash('success-register', 'Đăng ký tài khoản thành công');
                return redirect() -> route('login.customer');
            }
        }
        catch(\Exception $e){
            Session::flash('error', 'Đăng ký tài khoản thất bại ');
        }
        return redirect() -> back();
    }

    public function showFormLogin(){
        $title = 'Đăng nhập hệ thống';
        $categories = Category::where('active', 1) -> where('parent_id', 0) -> orderByDesc('id') -> get();
        return view('customer.formLogin', compact('title', 'categories'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email không được để trống',
            'password.required' => 'Mật khẩu không được để trống',
        ]);

        try {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                Session::flash('success-login', 'Đăng nhập thành công');
                return redirect('/');
            } else {
                Session::flash('error-login', 'Đăng nhập thất bại. Vui lòng kiểm tra lại email và mật khẩu.');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Đã xảy ra lỗi. Vui lòng thử lại.');
            return redirect()->back();
        }
    }

    public function logout(){
        if(!Auth::user()){
            return redirect() -> route('login.customer.form');
        }
        Auth::logout();
        Session::flash('success-logout', 'Đăng xuất thành công');
        return redirect('/');
    }
}
