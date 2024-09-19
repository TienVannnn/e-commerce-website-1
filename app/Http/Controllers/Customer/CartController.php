<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Jobs\SendMail;
use App\Models\Cart;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $cate;
    public function __construct(Category $category)
    {
        $this -> cate = $category;
    }
    public function addToCart(Request $request, $id){
        $product = Product:: find($id);
        $carts = session() -> get('carts');
        $quantity = $request->input('quantity', 1);
        if(isset($carts[$id])){
            $carts[$id]['quantity'] = $carts[$id]['quantity'] + $quantity;
        }
        else{
            $carts[$id] = [
                'name' => $product -> name,
                'price' => $product -> price,
                'image' => $product -> image,
                'quantity' => $quantity
            ];
        }
        session() -> put('carts', $carts);
        $countCarts = count(session('carts'));
        return response() -> json([
            'title' => 'Thành công',
            'message' => 'Thêm sản phẩm vào giỏ thành công',
            'status' => 200,
            'countCarts' => $countCarts
        ], 200);
    }

    public function showCarts(){
        $title = 'Giỏ hàng';
        $carts = session('carts');
        $categories = $this -> cate -> where('active', 1) -> where('parent_id', 0) -> orderByDesc('id') -> get();
        return view('customer.cart', compact('title', 'categories', 'carts'));
    }

    public function updateCart(Request $request, $id)
    {
        $quantity = $request->quantity;
        $carts = session()->get('carts');
        if (isset($carts[$id])) {
            $carts[$id]['quantity'] = $quantity;
            session()->put('carts', $carts);
            $subtotal = array_sum(array_map(function ($item) {
                return $item['price'] * $item['quantity'];
            }, $carts));
            return response()->json([
                'price' => $carts[$id]['price'],
                'quantity' => $quantity,
                'subtotal' => number_format($subtotal) . ' đ',
                'total' => number_format($subtotal + 10000) . ' đ'
            ], 200);
        }

        return response()->json(['error' => 'Product not found'], 404);
    }

    public function removeFromCart($id) {
        $carts = session()->get('carts', []);
        if(isset($carts[$id])) {
            unset($carts[$id]); 
            session()->put('carts', $carts); 
        }
        $subtotal = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $carts));
        $countCarts = count($carts);
        if ($countCarts === 0) {
            session()->forget('carts');
        }
        return response()->json([
            'status' => 200,
            'title' => 'Success',
            'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng',
            'countCarts' => $countCarts,
            'subtotal' => number_format($subtotal) . ' đ',
            'total' => number_format($subtotal + 10000) . ' đ'
        ]);
    }

    public function checkoutPage(){
        $carts = session('carts');
        $user = Auth::user();
        if(!$carts){
            return redirect() -> route('client.carts');
        }
        $title = 'Thanh toán';
        $categories = $this -> cate -> where('active', 1) -> where('parent_id', 0) -> orderByDesc('id') -> get();
        $carts = session('carts');
        return view('customer.checkout', compact('title', 'categories', 'carts', 'user'));
    }

    public function checkout(Request $request){
        $user = Auth::user();
        $request -> validate([
            'name' => 'required',
            'phone' => $user ? ['required', 'regex:/^(0[3|5|7|8|9])[0-9]{8}$/'] :  ['required', 'unique:users,phone', 'regex:/^(0[3|5|7|8|9])[0-9]{8}$/'],
            'email' => $user ? 'required|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i' : 'required|unique:users,email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/i',
            'address' => 'required'
        ],
        [
            'name.required' => 'Tên người dùng không được trống',
            'phone.required' => 'Số điện thoại không được trống',
            'phone.regex' => 'Số điện thoại không đúng định dạng',
            'email.regex' => 'Email không đúng định dạng',
            'email.required' => 'Email không được trống',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'email.unique' => 'Email đã tồn tại',
            'address.required' => 'Địa chỉ không được để trống'
        ]);
        try{
            DB::beginTransaction();
            $carts = session('carts');
            if(!$carts){
                abort(400);
            }
            
            $rand = rand(100000,999999);
            
            if($user){
                $user -> fill($request -> only('phone', 'address'));
                $user -> save();
            }
            else{
                $user = User::create([
                    'name' => $request -> name,
                    'phone' => $request -> phone,
                    'email' => $request -> email,
                    'password' => Hash::make($rand),
                    'address' => $request -> address
                ]);
            }
            $this -> createCart($carts, $user -> id);
            DB::commit();
            Session::put('success-cart','Đặt hàng thành công');
            #Queue
            SendMail::dispatch($user, $rand, $carts) -> delay(now() -> addSecond(2));
            session() -> forget('carts');
        }
        catch(\Exception $e){
            DB::rollBack();
            Session::flash('error','Đặt hàng thất bại ');
        }
        return redirect() -> back();
    }

    public function createCart($carts, $id){
        $invoice = Invoice::create([
            'name' => 'Hóa đơn #' . rand(1000, 9999) . $id,
            'user_id' => $id,
            'created_at' => date(Carbon::now('Asia/Ho_Chi_Minh'))
        ]);

        $invoice_id = $invoice -> id;

        $productId = array_keys($carts);
        $products = Product::where('active', 1) -> whereIn('id', $productId) -> get();
        $data = [];
        foreach($products as $product){
            $data[] = [
                'invoice_id' => $invoice_id,
                'product_id' => $product -> id,
                'quantity' => $carts[$product -> id]['quantity'],
                'total_price' => $carts[$product -> id]['price'] * $carts[$product -> id]['quantity'],
                // 'created_at' => 
            ];
        }
        return InvoiceDetail::insert($data);
    }
    
}
