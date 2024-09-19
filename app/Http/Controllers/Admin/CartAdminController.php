<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Service\CartAdminService;
use Illuminate\Http\Request;

class CartAdminController extends Controller
{
    protected $cart;
    public function __construct(CartAdminService $cart)
    {
        $this -> cart = $cart;
    }
    public function index()
    {
        $title = 'Danh sách đơn hàng';
        $user = $this -> cart -> getUser();
        $carts = Cart::where('');
        return view('admin.cart.list', compact('title', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
