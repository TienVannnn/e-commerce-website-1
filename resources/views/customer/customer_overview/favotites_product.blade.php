@extends('customer.customer_overview.layout_customer')

@section('content-customer')
    <?php 
    $count = 0;
    ?>
@if($products -> count() > 0 )
      <p class="font-weight-bold text-primary">SẢN PHẨM YÊU THÍCH</p>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum dignissimos, voluptatem eaque nesciunt, exercitationem excepturi nemo voluptate eligendi temporibus necessitatibus labore voluptates minima unde, atque voluptatibus iste a sunt tempore!</p>
      <table class="table table-content table-bordered table-head-bg-info table-bordered-bd-info text-center align-items-center">
        <thead>
          <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên sản phẩm</th>
            <th scope="col">Hình ảnh</th>
            <th scope="col">Giá tiền</th>
            <th scope="col">Chi tiết</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($products as  $product)
          <?php  
            $count += 1
          ?>
            <tr>
                <th> {{ $count }}</th>
                <th>{{ $product -> product ->name }}</th> 
                <th><img src="/uploads/products/{{ $product -> product -> image }}" alt="{{ $product -> product ->name }}" width="50"></th> 
                <th>{{ number_format($product -> product -> price) }}đ</th>
                <th>
                    <div class="d-flex align-items-center border-none justify-content-center">
                        <a title="Thêm sản phẩm vào giỏ hàng" class="btn btn-success btn-sm addToCart mr-2" 
                        data-url="{{ route('addToCart', ['id' => $product -> product ->id]) }}">
                        <i class="fas fa-shopping-cart"></i>
                    </a>    
                    <form action="{{ route('delete-favorite-product', $product -> product -> id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi danh sách yêu thích?')" type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash" title="Xóa sản phẩm này khỏi danh sách yêu thích"></i></button>
                    </form>
                    </div>
                </th>
            </tr>
          @endforeach
        </tbody>
      </table>
      <div class="d-flex justify-content-center">
        {{ $products -> links() }}
      </div>
@else
    <div>
        <p>Chưa có sản phẩm yêu thích nào!</p> <br>
        <a href="" class="btn btn-warning">Mua sắm ngay</a>
    </div>
@endif
@endsection