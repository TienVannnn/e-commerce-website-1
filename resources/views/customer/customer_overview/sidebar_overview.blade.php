<div class="col-lg-3 col-md-4">
    <div class="bg-light mb-30 tab1">
        <ul class="sidebar-overview tab2">
            <li class="custom-control custom-checkbox d-flex align-items-center justify-content-center">
                <a href="{{ route('overview') }}" class="btn btn-block py-3 overview-btn"> <i class="fas fa-home"></i> Tổng quan</a>
            </li>
            <li class="custom-control custom-checkbox d-flex align-items-center justify-content-center">
                <a href="{{ route('overview.orders') }}" class="btn btn-block py-3 overview-btn"><i class="fas fa-cart-plus"></i> Đơn hàng</a>
            </li>
            <li class="custom-control custom-checkbox d-flex align-items-center justify-content-center">
                <a href="{{ route('overview.favorite') }}" class="btn btn-block py-3 overview-btn"><i class="fas fa-heart"></i> Sản phẩm yêu thích</a>
            </li>
            <li class="custom-control custom-checkbox d-flex align-items-center justify-content-center">
                <a href="{{ route('overview.account') }}" class="btn btn-block py-3 overview-btn"><i class="fas fa-wrench"></i> Cài đặt tài khoản</a>
            </li>
            <li class="custom-control custom-checkbox d-flex align-items-center justify-content-center">
                <a href="{{ route('overview.logout') }}" class="btn btn-block py-3 overview-btn"><i class="fas fa-user-lock"></i> Đăng xuất</a>
            </li>
        </ul>
    </div>
</div>