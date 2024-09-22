@extends('customer.layout.main')

{{-- @section('js')
    <script></script>
@endsection --}}

@section('content')
@include('customer.layout.breadcrum')
    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by price</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form id="priceFilterForm" data-category="{{ $category -> id }}">
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="price-all">
                            <label class="custom-control-label" for="price-all">All Price</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" name="price_range[]" value="0-1000000" id="price-1">
                            <label class="custom-control-label" for="price-1">0 - 1,000,000đ</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" name="price_range[]" value="1000000-5000000" id="price-2">
                            <label class="custom-control-label" for="price-2">1,000,000đ - 5,000,000đ</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" name="price_range[]" value="5000000-30000000" id="price-3">
                            <label class="custom-control-label" for="price-3">5,000,000đ - 30,000,000đ</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" name="price_range[]" value="30000000-100000000" id="price-4">
                            <label class="custom-control-label" for="price-4">30,000,000đ - 100,000,000đ</label>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" name="price_range[]" value="100000000-10000000000" id="price-5">
                            <label class="custom-control-label" for="price-5"> > 100,000,000đ</label>
                        </div>
                    </form>
                </div>
                <!-- Price End -->
                
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                            <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                        </div>
                        <div class="ml-2">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Sắp xếp</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#" data-sort="Latest">Mới nhất</a>
                                    <a class="dropdown-item" href="#" data-sort="Oldest">Cũ nhất</a>
                                    {{-- <a class="dropdown-item" href="#" data-sort="Best Rating">B</a> --}}
                                </div>
                            </div>
                            <div class="btn-group ml-2">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Hiển thị</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#" data-limit="9">9</a>
                                    <a class="dropdown-item" href="#" data-limit="15">15</a>
                                    <a class="dropdown-item" href="#" data-limit="30">30</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pb-3">
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100" src="/uploads/products/{{ $product -> image }}" alt="" style="height: 326px">
                                    <div class="product-action">
                                        <a title="Thêm sản phẩm này vào giỏ hàng" class="btn btn-outline-dark btn-square addToCart"data-url="{{ route('addToCart',  $product -> id) }}" ><i class="fa fa-shopping-cart"></i></a>
                                        <a title="Thích sản phẩm này" class="btn btn-outline-dark btn-square addFavoriteProduct" 
                                            data-url="{{ route('addFavoriteProduct', $product->id) }}">
                                            <i class="far fa-heart"></i>
                                        </a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href="{{ route('product-c', $product -> slug) }}">{{ $product -> name }}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>{{ number_format($product -> price) }}</h5><h6 class="text-muted ml-2"><del>{{ number_format($product -> price) }}</del></h6>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small>(99)</small>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    @endforeach
                    <div class="col-12 d-flex justify-content-center">
                        {{ $products -> links() }}
                    </div>
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->

@endsection