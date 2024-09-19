@extends('admin.layout_admin.main')

@section('content')
    <div class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
            <li class="breadcrumb-item active" aria-current="page">Chi tiết đơn hàng</li>
            </ol>
        </nav>
    </div>
    <div class="container text-center">
        <h2>Chi tiết {{ $order -> name }}</h2>
        <p><span class="fw-bold">Tên khách hàng:</span> {{ $order -> user -> name }}</p>
        <p><span class="fw-bold">Số điện thoại:</span> {{ $order -> user -> phone }}</p>
        <p><span class="fw-bold">Email:</span> {{ $order -> user -> email }}</p>
        <p><span class="fw-bold">Địa chỉ:</span> {{ $order -> user -> address }}</p>
    </div>
    <?php
        $total_price = 0;
    ?>
    <table class="table table-content table-responsive  table-bordered table-head-bg-info table-bordered-bd-info text-center">
        <thead>
          <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên sản phẩm</th>
            <th scope="col">Ảnh</th>
            <th scope="col">Giá tiền</th>
            <th scope="col">Số lượng</th>
            <th scope="col">Thành tiền</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($order -> invoiceDetails as $key => $detail)
          <?php 
            $total_price += $detail -> total_price
          ?>
            <tr>
                <td> {{ $key + 1 }}</td>
                <td>{{ $detail -> product -> name }}</td> 
                <td><img src="/uploads/products/{{ $detail -> product -> image }}" alt="{{ $detail -> product -> name }}" width="50"></td>
                <td>{{ number_format($detail -> product -> price) }}đ</td>
                <td>{{ $detail -> quantity }}</td>
                <td>{{ number_format($detail -> total_price) }}đ</td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('orders.index') }}" class="btn btn-primary">Quay lại</a>
          <div>
            <p class="text-right"><span class="fw-bold">Tạm tính:</span> {{ number_format($total_price) }}đ</p>
            <p class="text-right"><span class="fw-bold">Phí vận chuyển:</span>10.000đ</p>
            <p class="text-right"><span class="fw-bold">TỔNG TIỀN:</span> {{ number_format($total_price + 10000) }}đ</p>                                  
          </div>
      </div>
@endsection