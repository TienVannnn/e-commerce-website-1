@extends('customer.layout.main')

@section('js')
  <script src="/template/customer/js/rating.js"></script>

  <!-- FilePond CSS -->
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css" rel="stylesheet">

    <!-- FilePond JS -->
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>

  <script src="/template/customer/js/upload.js"></script>
@endsection

@section('css')
 <link rel="stylesheet" href="/template/customer/css/fix-image.css">
@endsection

@section('content')

@include('customer.layout.breadcrum')

<!-- Shop Detail Start -->
<div class="container-fluid pb-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 mb-30">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner bg-light">
                    @if ($product -> images_detail -> isNotEmpty())
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="/uploads/products/{{ $product -> image }}" alt="Image">
                        </div>
                        @foreach ($product -> images_detail as $img)
                            <div class="carousel-item">
                                <img class="w-100 h-100" src="/uploads/productDetails/{{ $img -> image_detail }}" alt="Image">
                            </div>
                        @endforeach
                    @else
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="/uploads/products/{{ $product -> image }}" alt="Image">
                        </div>
                    @endif
                </div>
                @if ($product -> images_detail -> isNotEmpty())
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-3x fa-angle-left text-warning"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-3x fa-angle-right text-warning"></i>
                    </a>
                @endif
            </div>
        </div>

        <div class="col-lg-7 h-auto mb-30">
            <div class="h-100 bg-light p-30">
                <h3>{{ $product -> name }}</h3>
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star"></small>
                        <small class="fas fa-star-half-alt"></small>
                        <small class="far fa-star"></small>
                    </div>
                    <small class="pt-1">(99 Reviews)</small>
                </div>
                <h3 class="font-weight-semi-bold mb-4">{{ number_format($product -> price) }}đ</h3>
                <p class="mb-4">{{ $product -> short_des }}</p>
                <a title="Thích sản phẩm này" class="btn btn-outline-dark addFavoriteProduct mb-4" 
                                data-url="{{ route('addFavoriteProduct', ['id' => $product->id]) }}">
                                <i class="far fa-heart"></i>
                Thích sản phẩm</a>
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantityy mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-minuss">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" class="form-control bg-secondary border-0 text-center quantity-product" value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-pluss">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button class="btn btn-primary px-3 addToCartWithQuantity" data-url="{{ route('addToCart', ['id' => $product -> id]) }}"><i class="fa fa-shopping-cart mr-1"></i> 
                        Add To Cart
                    </button>
                </div>
                <div class="d-flex pt-2">
                    <strong class="text-dark mr-2">Share on:</strong>
                    <div class="d-inline-flex">
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a class="text-dark px-2" href="">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="bg-light p-30">
                <div class="nav nav-tabs mb-4">
                    <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#description">Mô tả</a>
                    <a class="nav-item nav-link text-dark" data-toggle="tab" href="#information">Information</a>
                    <a class="nav-item nav-link text-dark" data-toggle="tab" href="#reviews">Đánh giá (0)</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="description">
                        {!! $product -> content !!}
                    </div>
                    <div class="tab-pane fade" id="information">
                        <h4 class="mb-3">Additional Information</h4>
                        <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                    </li>
                                  </ul> 
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0">
                                        Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                    </li>
                                    <li class="list-group-item px-0">
                                        Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                    </li>
                                  </ul> 
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="reviews">
                        <div class="row">
                            <div class="col-md-6">
                                {{-- <h4 class="mb-4">1 review for "Product Name"</h4>
                                <div class="media mb-4">
                                    <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                    <div class="media-body">
                                        <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                        <div class="text-primary mb-2">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                            <i class="far fa-star"></i>
                                        </div>
                                        <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsum et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Viết đánh giá</h4>
                                <p>Email của bạn sẽ không được công khai. Các trường bắt buộc được đánh dấu *</p>
                            
                                @guest
                                    <p>Vui lòng <a href="{{ route('login.customer.form') }}">đăng nhập</a> để viết đánh giá</p>
                                @endguest
                            
                                
                                <form action="{{ route('review', $product->slug) }}" method="POST" enctype="multipart/form-data">
                                    <div class="d-flex my-3">
                                        <p class="mb-0 mr-2">Số sao * :</p>
                                        <div class="text-primary star-rating">
                                            <i class="far fa-star" data-value="1"></i>
                                            <i class="far fa-star" data-value="2"></i>
                                            <i class="far fa-star" data-value="3"></i>
                                            <i class="far fa-star" data-value="4"></i>
                                            <i class="far fa-star" data-value="5"></i>
                                        </div>
                                        <input type="hidden" name="rate" id="rate" value="0">
                                    </div>
                                    @csrf
                                    <div class="form-group">
                                        <label for="message">Đánh giá *</label>
                                        <textarea 
                                            placeholder="Viết đánh giá của bạn..." 
                                            id="message" 
                                            name="content"
                                            cols="30" 
                                            rows="5" 
                                            class="form-control" 
                                            required
                                            @guest readonly @endguest
                                        ></textarea>
                                    </div>
                                    <input type="file" name="image[]" multiple id="filepond" data-max-file-size="2MB" data-max-files="6">
                                    {{-- <input type="hidden" name="images[]" value=""> --}}
                                    <div id="images-container"></div> 
                                    <div class="form-group mb-0">
                                        <input type="submit" value="Gửi đánh giá" class="btn btn-primary px-3" @guest disabled @endguest>
                                    </div>
                                </form>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->


<!-- Products Start -->
<div class="container-fluid py-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Có thể bạn cũng thích</span></h2>
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel related-carousel">
                @foreach ($relativeProducts as $productItem)
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="/uploads/products/{{ $productItem -> image }}" alt="{{ $productItem -> name }}" style="height: 326px">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="far fa-heart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="">{{ $productItem -> name }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{ number_format($productItem -> price) }}</h5><h6 class="text-muted ml-2"><del>{{ number_format($productItem -> price) }}</del></h6>
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
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Products End -->
@endsection