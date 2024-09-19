@extends('admin.layout_admin.main')

@section('content')
    <div class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
              <li class="breadcrumb-item active" aria-current="page">Order</li>
            </ol>
        </nav>
    </div>
    <div class="container">
        @include('admin.layout_admin.alert')
    </div>
    @if($orders -> isNotEmpty())
    <table class="table table-content table-responsive  table-bordered table-head-bg-info table-bordered-bd-info text-center">
        <thead>
          <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên khách hàng</th>
            <th scope="col">Email</th>
            <th scope="col">SDT</th>
            <th scope="col">Đơn hàng</th>
            <th scope="col">Chi tiết</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($orders as $key => $order)
            <tr>
                <td> {{ $key + 1 }}</td>
                <td>{{ $order->user->name }}</td> 
                <td>{{ $order->user->email }}</td>
                <td>{{ $order->user->phone }}</td>
                <td>{{ $order->name }}</td> 
                <td>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm" title="Xem chi tiết">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      {{ $orders -> links() }}
    @else 
    <table class="table table-content table-responsive  table-bordered table-head-bg-info table-bordered-bd-info text-center">
        <thead>
          <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên khách hàng</th>
            <th scope="col">Email</th>
            <th scope="col">SDT</th>
            <th scope="col">Đơn hàng</th>
          </tr>
        </thead>
        <tbody >
            <p class="text-center text-danger">Không có đơn hàng nào!</p>
        </tbody>
      </table>
    @endif
@endsection