<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Service\CartAdminService;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index()
    {
        $title = 'Danh sách đơn hàng';
        $orders = Invoice::orderByDesc('id') -> paginate(10);
        return view('admin.order.list', compact('title', 'orders'));
    }

    public function show(string $id)
    {
        $order = Invoice::find($id);
        $title = 'Xem chi tiết đơn hàng ' . $order -> name;
        return view('admin.order.show', compact('title', 'order'));
    }

    public function destroy(string $id)
    {
        //
    }
}
