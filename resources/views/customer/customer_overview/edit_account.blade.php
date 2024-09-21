@extends('customer.customer_overview.layout_customer')

@section('content-customer')
        <div class="bg-light p-30">
            @include('admin.layout_admin.alert')
            @include('admin.layout_admin.hide')
            <div class="nav nav-tabs mb-4">
                <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#profile">Hồ sơ</a>
                <a class="nav-item nav-link text-dark" data-toggle="tab" href="#change-password">Đổi mật khẩu</a>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="profile">
                    <form action="{{ route('overview.handleUpdateAccount') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ $user -> name }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" value="{{ $user -> email }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="phone">Điện thoại</label>
                            <input type="number" name="phone" class="form-control" id="phone" value="{{ $user ? $user -> phone : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="add">Địa chỉ</label>
                            <input type="text" name="address" class="form-control" id="add" value="{{ $user ? $user -> address : '' }}">
                        </div>
                        <div class="form-group mb-5">
                            <button type="submit" class="btn btn-primary px-3">Cập nhật</button>
                        </div>
                    </form>
                    <div class="form-group mb-5 border p-3">
                        <h3>Xóa tài khoản</h3>
                        <p>Hành động này sẽ xóa vĩnh viễn tài khoản của bạn cũng như tất cả dữ liệu liên quan và không thể thay đổi được. Hãy chắc chắn trước khi tiếp tục.</p>
                        <a href="{{ route('overview.handleDeleteAccount') }}" class="btn btn-primary px-3" title="Xóa tài khoản vĩnh viễn" onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?')">Xóa tài khoản</a>
                    </div>
                </div>
                <div class="tab-pane fade" id="change-password">
                    <form action="{{ route('overview.changePassword') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="pass">Mật khẩu hiện tại *</label>
                            <input type="password" name="password" class="form-control" id="pass">
                        </div>
                        <div class="form-group">
                            <label for="newpass">Mật khẩu mới *</label>
                            <input type="password" name="newpass" class="form-control" id="newpass">
                        </div>
                        <div class="form-group">
                            <label for="confirm">Xác nhận mật khẩu *</label>
                            <input type="password" name="newpass_confirmation" class="form-control" id="confirm">
                        </div>
                        <p>Hành động này sẽ làm thay đổi mật khẩu hiện tại của bạn. Hãy chắc chắn bạn ghi nhớ mật khẩu mới tài khoản của bạn để đảm bảo khi đăng nhập lại.</p>
                        <div class="form-group mb-5">
                            <button type="submit" class="btn btn-primary px-3">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection