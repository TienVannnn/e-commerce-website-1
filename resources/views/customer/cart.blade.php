@extends('customer.layout.main')

@section('js')
    <script src="/template/customer/js/update-cart.js"></script>
@endsection

@section('content')
@include('customer.layout.breadcrum')

     <!-- Cart Start -->
     <?php
        $subtotal = 0;
    ?>
     <div class="container-fluid">
        @if($carts)
        <div class="no-product-cart"></div>
            <div class="row checkout-row px-xl-5">
                <div class="col-lg-8 table-responsive mb-5">
                    <table class="table table-light table-borderless table-hover text-center mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng giá tiền</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                                @foreach ($carts as $id => $item)
                                <?php 
                                    $subtotal += $item['price'] * $item['quantity']; // Tính tổng tiền
                                ?>
                                    <tr>
                                        <td class="align-middle"><img src="/uploads/products/{{ $item['image'] }}" alt="" style="width: 50px;">{{ $item['name'] }}</td>
                                        <td class="align-middle" id="price-{{ $id }}">{{ number_format($item['price']) }} đ</td>
                                        <td class="align-middle">
                                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-primary btn-minus" data-id="{{ $id }}">
                                                    <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center quantity-input" data-id="{{ $id }}" value="{{ $item['quantity'] }}">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-primary btn-plus" data-id="{{ $id }}">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle" id="total-{{ $id }}">{{ number_format($item['price'] * $item['quantity']) }} đ</td>
                                        <td class="align-middle"><button onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')" class="btn btn-sm btn-danger btn-remove-product" data-id="remove-{{ $id }}" data-url="{{ route('cart.remove', $id) }}"><i class="fa fa-times"></i></button></td>
                                    </tr>
                                @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-4">
                    <form class="mb-30" action="">
                        <div class="input-group">
                            <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
                            <div class="input-group-append">
                                <button class="btn btn-primary">Apply Coupon</button>
                            </div>
                        </div>
                    </form>
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Tổng tiền</span></h5>
                    <div class="bg-light p-30 mb-5">
                        <div class="border-bottom pb-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h6>Tạm tính</h6>
                                <h6 id="subtotal">{{ number_format($subtotal) }}đ</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Phí vận chuyển</h6>
                                <h6 class="font-weight-medium">10.000đ</h6>
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="d-flex justify-content-between mt-2">
                                <h5>Thành tiền</h5>
                                <h5 id="total-sumary">{{ number_format($subtotal + 10000) }}đ</h5>
                            </div>
                            <a href="{{ route('page_checkout') }}" class="btn btn-block btn-primary font-weight-bold my-3 py-3">Tiến hành thanh toán</a>
                        </div>
                    </div>
                </div>
            </div>
        @else <p class="text-center text-danger">Không có sản phẩm nào trong giỏ hàng của bạn!</p>
        @endif
    </div>
    <!-- Cart End -->
@endsection