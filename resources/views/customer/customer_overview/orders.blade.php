@extends('customer.customer_overview.layout_customer')

@section('content-customer')
   <div class="tab">
    <?php 
    $count = 0;
?>
@if($orders -> count() > 0 )
    <div class="text-center">
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores, quam sed? Explicabo minus itaque vitae deserunt quo quis optio, quam possimus, iure voluptatibus quas! Temporibus ab provident veniam quaerat? A?</p>
      <p class="text-center font-weight-bold">Thông tin đơn hàng của bạn</p>
      <table class="table table-content table-bordered table-head-bg-info table-bordered-bd-info text-center">
        <thead>
          <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên hóa đơn</th>
            <th scope="col">Ngày đặt</th>
            {{-- <th scope="col"></th>
            <th scope="col">Đơn hàng</th> --}}
            <th scope="col">Chi tiết</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($orders as $key => $order)
          <?php  
            $count += 1
          ?>
            <tr>
                <td> {{ $count }}</td>
                <td>{{ $order ->name }}</td> 
                <td>{{ $order-> created_at }}</td>
                {{-- <td>{{ $order->user->phone }}</td>
                <td>{{ $order->name }}</td>  --}}
                <td>
                    <a href="{{ route('overview.order.detail', $order->id) }}" class="btn btn-primary btn-sm" title="Xem chi tiết">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="d-flex justify-content-center">
        {{ $orders -> links() }}
      </div>
    </div>
@else
    <p>Chưa có đơn hàng nào!</p> <br>
    <a href="" class="btn btn-warning">Mua sắm ngay</a>
@endif
   </div>
@endsection