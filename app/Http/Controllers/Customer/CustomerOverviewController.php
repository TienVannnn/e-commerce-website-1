<?php

namespace App\Http\Controllers\Customer;

use App\Models\Invoice;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FavoriteProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomerOverviewController extends Controller
{
    public function overview(){
        if(!Auth::user()){
            return redirect() -> route('login.customer.form');
        }
        $title = 'Thông tin khách hàng';
        $user = Auth::user();
        $categories = Category::where('active', 1) -> where('parent_id', 0) -> orderByDesc('id') -> get();
        return view('customer.customer_overview.overview', compact('title', 'categories', 'user'));
    }

    public function orders(){
        if(!Auth::user()){
            return redirect() -> route('login.customer.form');
        }
        $title = 'Thông tin khách hàng - Đơn hàng';
        $user = Auth::user();
        $orders = Invoice::where('user_id', $user -> id) -> orderbyDesc('id') -> paginate(5);
        $categories = Category::where('active', 1) -> where('parent_id', 0) -> orderByDesc('id') -> get();
        return view('customer.customer_overview.orders', compact('title', 'categories', 'user', 'orders'));
    }

    public function order_detail($id){
        $user = Auth::user();
        if(!$user){
            return redirect() -> route('login.customer.form');
        }
        $order = Invoice::where('id', $id) -> where('user_id', $user -> id) -> first();
        if(!$order){
            abort(404);
        }
        $title = 'Chi tiết đơn hàng ' . $order -> name;
        $categories = Category::where('active', 1) -> where('parent_id', 0) -> orderByDesc('id') -> get();
        return view('customer.customer_overview.order_detail', compact('title', 'order', 'categories'));
    }

    public function favorites_product(){
        $user = Auth::user();
        if(!$user){
            return redirect() -> route('login.customer.form');
        }
        $title = 'Thông tin khách hàng - Sản phẩm yêu thích';
        $categories = Category::where('active', 1) -> where('parent_id', 0) -> orderByDesc('id') -> get();
        $products = FavoriteProduct::where('user_id', $user -> id) -> paginate(10);
        return view('customer.customer_overview.favotites_product', compact('title', 'categories', 'user', 'products'));
    }

    public function edit_account(){
        if(!Auth::user()){
            return redirect() -> route('login.customer.form');
        }   
        $title = 'Thông tin khách hàng - Hồ sơ';
        $user = Auth::user();
        $categories = Category::where('active', 1) -> where('parent_id', 0) -> orderByDesc('id') -> get();
        return view('customer.customer_overview.edit_account', compact('title', 'categories', 'user'));
    }

    public function handleUpdateAccount(Request $request){  
        $user = Auth::user();
        if(!$user){
            return redirect() -> route('login.customer');
        }
        $request->validate([
            'name' => 'required|min:6',
            'phone' => ['required', 'regex:/^(0[3|5|7|8|9])[0-9]{8}$/', 'unique:users,phone,' . $user->id], 
            'address' => 'required',
        ], [
            'name.required' => 'Tên không được để trống',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'phone.regex' => 'Số điện thoại không hợp lệ',
            'address.required' => 'Địa chỉ không được để trống',
        ]);
        try{
            $user -> fill($request -> only('name', 'phone', 'address')) -> save();
            Session::flash('success-editaccount', 'Cập nhật tài khoản thành công');
        }
        catch(\Exception $e){
            Session::flash('error', 'Cập nhật thông tin tài khoản thất bại');
        }
        return redirect() -> back();
    }

    public function changePassword(Request $request){
        $user = Auth::user();
        if(!$user){
            return redirect() -> route('login.customer.form');
        }
        $request -> validate([
            'password' => 'required',
            'newpass' => 'required|min:6|max:50|confirmed'
        ],[
            'password.required' => 'Cần nhập mật khẩu hiện tại để đổi mật khẩu mới',
            'newpass.required' => 'Nhập mật khẩu mới để đổi',
            'newpass.confirmed' => 'Xác nhận mật khẩu không hợp lệ',
            'newpass.min' => 'Mật khẩu ít nhất phải 6 ký tự', 
            'newpass.max' => 'Mật khẩu tối đa 50 ký tự', 
        ]);
        try{
            if (Hash::check($request->password, $user->password)) {
                $user->password = Hash::make($request->newpass);
                $user->save();
                Session::flash('success-changePass', 'Đổi mật khẩu thành công');
            }
            else Session::flash('error-changePass', 'Mật khẩu hiện tại không hợp lệ. Vui lòng thử lại!');
        }
        catch(\Exception $e){
            Session::flash('error', 'Đổi mật khẩu thất bại');
        }
        return redirect() -> back();
    }

    public function delete_favorite_product($id){
        $product = FavoriteProduct::where('product_id', $id) -> first();
        if(!$product){
            abort(404);
        }
        $product -> delete();
        Session::flash('success-delete-favo', 'Xóa sản phẩm yêu thích thành công');
        return redirect() -> back();
    }

    public function handleDeleteAccount(){
        $user = Auth::user();
        if(!$user){
            return redirect() -> route('login.customer.form');
        }
        try{
            $items = FavoriteProduct::where('user_id', $user -> id) -> get();
            foreach($items as $item){
                $item -> delete();
            }
            $user -> delete();
            Session::flash('success-delete-account', 'Xóa tài khoản thành công');
        }
        catch(\Exception $e){
            Session::flash('error-delete-account', 'Xóa tài khoản lỗi');
        }
        return redirect('/');
    }
}
