@extends('customer.customer_overview.layout_customer')

@section('content-customer')
    <div class="bg-light p-4">
        <div class="d-flex align-items-center p-1">
            <p class="">Xin chào </p>
            <p class="font-weight-bold text-warning font-semibold ml-1"> {{ $user -> name }}</p>
        </div>
        <p>Từ trang tổng quan tài khoản của mình, bạn có thể xem <a href="">các đơn đặt hàng gần đây</a>, quản lý vận chuyển của mình và <a href="">địa chỉ thanh toán</a>, đồng thời <a href="">chỉnh sửa chi tiết mật khẩu và tài khoản của bạn</a>.</p>
    </div>
@endsection