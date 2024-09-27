@extends('customer.layout.main')

{{-- @section('css')
<link rel="stylesheet" href="/template/bem/style.css">
@endsection --}}

@section('content')
<div id="toast"></div>
<!-- Carousel Start -->
<div class="container-fluid mb-3">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#header-carousel" data-slide-to="1"></li>
                    <li data-target="#header-carousel" data-slide-to="2"></li>
                    {{-- <li data-target="#header-carousel" data-slide-to="3"></li>
                    <li data-target="#header-carousel" data-slide-to="4"></li> --}}
                </ol>
                <div class="carousel-inner">
                @foreach ($sliders as $key => $slider)
                        <div class="carousel-item position-relative {{ $key == 0 ? 'active' : '' }}" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="/uploads/sliders/{{ $slider -> image }}" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">{{ $slider -> name }}</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">{!! $slider -> description !!}</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="#">Shop Now</a>
                                </div>
                            </div>
                        </div>
                @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="product-offer mb-30" style="height: 200px;">
                <img class="img-fluid" src="/template/customer/img/offer-1.jpg" alt="">
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">Save 20%</h6>
                    <h3 class="text-white mb-3">Special Offer</h3>
                    <a href="" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
            <div class="product-offer mb-30" style="height: 200px;">
                <img class="img-fluid" src="/template/customer/img/offer-2.jpg" alt="">
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">Save 20%</h6>
                    <h3 class="text-white mb-3">Special Offer</h3>
                    <a href="" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Carousel End -->


<!-- Featured Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
            </div>
        </div>
    </div>
</div>
<!-- Featured End -->


<!-- Categories Start -->
<div class="container-fluid pt-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Danh mục</span></h2>
    <div class="row px-xl-5 pb-3">
        @foreach ($categories as $category)
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="{{ route("category-c", $category -> slug) }}">
                    <div class="cat-item d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 100px;">
                            <img class="img-fluid" src="/uploads/category/{{ $category -> img }}" alt="">
                        </div>
                        <div class="flex-fill pl-3">
                            <h6>{{ $category -> name }}</h6>
                            <small class="text-body">{{ $category -> totalProducts() }} sản phẩm</small>
                        </div>
                    </div>
                </a>
            </div> 
        @endforeach
    </div>
</div>
<!-- Categories End -->


<!-- Products Start -->
<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Sản phẩm nổi bật</span></h2>
    <div class="row px-xl-5">
        @foreach ($productFeatured as $product)
        <?php
            $reviews = $product -> reviews;
            $sum = $reviews -> sum('rate');
            $count = $reviews -> count();
            $avgRate = $count > 0 ? floor($sum / $count) : 5;
        ?>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="/uploads/products/{{ $product -> image }}" alt=""  style="height: 326px">
                        <div class="product-action">
                            <a title="Thêm sản phẩm này vào giỏ hàng" class="btn btn-outline-dark btn-square addToCart"data-url="{{ route('addToCart', ['id' => $product -> id]) }}" ><i class="fa fa-shopping-cart"></i></a>
                            <a title="Thích sản phẩm này" class="btn btn-outline-dark btn-square addFavoriteProduct" 
                                data-url="{{ route('addFavoriteProduct', ['id' => $product->id]) }}">
                                <i class="far fa-heart"></i>
                            </a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="{{ route('product-c', $product -> slug) }}">{{ $product -> name }}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>{{ number_format($product -> price) }}đ</h5><h6 class="text-muted ml-2"><del>{{ number_format($product -> price) }}đ</del></h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($product->avgRate))
                                    <small class="fas fa-star text-primary"></small>
                                @elseif ($i == ceil($product->avgRate))
                                    @if (($product->avgRate - floor($product->avgRate)) == 0.5)
                                        <small class="fas fa-star-half-alt text-primary"></small>
                                    @else
                                        <small class="far fa-star text-primary"></small>
                                    @endif
                                @else
                                    <small class="far fa-star text-primary"></small>
                                @endif
                            @endfor
                            <small>(Đã bán {{ $product -> quantity_sold }})</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<!-- Products End -->


<!-- Offer Start -->
<div class="container-fluid pt-5 pb-3">
    <div class="row px-xl-5">
        <div class="col-md-6">
            <div class="product-offer mb-30" style="height: 300px;">
                <img class="img-fluid" src="/template/customer/img/offer-1.jpg" alt="">
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">Save 20%</h6>
                    <h3 class="text-white mb-3">Special Offer</h3>
                    <a href="" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="product-offer mb-30" style="height: 300px;">
                <img class="img-fluid" src="/template/customer/img/offer-2.jpg" alt="">
                <div class="offer-text">
                    <h6 class="text-white text-uppercase">Save 20%</h6>
                    <h3 class="text-white mb-3">Special Offer</h3>
                    <a href="" class="btn btn-primary">Shop Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Offer End -->


<!-- Products Start -->
<div class="container-fluid pt-5 pb-3">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Sản phẩm mới ra mắt</span></h2>
    <div class="row px-xl-5">
        @foreach ($recentProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="/uploads/products/{{ $product -> image }}" alt="" style="height: 326px">
                        <div class="product-action">
                            <a title="Thêm sản phẩm này vào giỏ hàng" class="btn btn-outline-dark btn-square addToCart"data-url="{{ route('addToCart', ['id' => $product -> id]) }}" ><i class="fa fa-shopping-cart"></i></a>
                            <a title="Thích sản phẩm này" class="btn btn-outline-dark btn-square addFavoriteProduct" 
                                data-url="{{ route('addFavoriteProduct', ['id' => $product->id]) }}">
                                <i class="far fa-heart"></i>
                            </a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="{{ route('product-c', $product -> slug) }}">{{ $product -> name }}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>{{ number_format($product -> price) }}đ</h5><h6 class="text-muted ml-2"><del>{{ number_format($product -> price) }}đ</del></h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($product->avgRate))
                                    <small class="fas fa-star text-primary"></small>
                                @elseif ($i == ceil($product->avgRate))
                                    @if (($product->avgRate - floor($product->avgRate)) == 0.5)
                                        <small class="fas fa-star-half-alt text-primary"></small>
                                    @else
                                        <small class="far fa-star text-primary"></small>
                                    @endif
                                @else
                                    <small class="far fa-star text-primary"></small>
                                @endif
                            @endfor
                            <small>(Đã bán {{ $product -> quantity_sold }})</small>
                        </div>
                    </div>
                </div>
            </div>   
        @endforeach
    </div>
</div>
<!-- Products End -->


<!-- Vendor Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel vendor-carousel">
                <div class="bg-light p-4">
                    <img src="/template/customer/img/vendor-1.jpg" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="/template/customer/img/vendor-2.jpg" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="/template/customer/img/vendor-3.jpg" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="/template/customer/img/vendor-4.jpg" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="/template/customer/img/vendor-5.jpg" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="/template/customer/img/vendor-6.jpg" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="/template/customer/img/vendor-7.jpg" alt="">
                </div>
                <div class="bg-light p-4">
                    <img src="/template/customer/img/vendor-8.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Vendor End -->
@endsection