<?php

// namespace App\Http\Controllers\Admin;

// use App\Models\Manager;
// use Illuminate\Http\Request;
// use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Session;

// class AuthController extends Controller
// {
//     public function showLoginForm(){
//         return view('admin.auth.formLogin');
//     }

//     public function login(Request $request){
//         $request -> validate([
//             'email' => 'required|email',
//             'password' => 'required'
//         ]);
//         $manager = Manager::where('email', $request -> email) -> first();
//         if($manager){
//             if(Hash::check($request -> password, $manager -> password)){
//                 Auth::login($manager);
//                 return redirect('/admin');
//             }
//             Session::flash('error', 'Password không hợp lệ');
//             return redirect() -> route('login');
//         }
//         Session::flash('error', 'Email không hợp lệ');
//         return redirect() -> route('login');
//     }
// }



namespace App\Http\Controllers\Admin;

use App\Models\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if(Auth::guard('manager') -> check()){
            return redirect('/admin');
        }
        return view('admin.auth.formLogin');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::guard('manager')->attempt($credentials, $request->has('remember'))) {
            return redirect()->route('admin.home'); 
        }
        Session::flash('error', 'Email hoặc mật khẩu không hợp lệ');
        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::guard('manager')->logout();
        return redirect()->route('login');
    }
}
