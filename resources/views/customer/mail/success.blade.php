<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="/template/admin/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/template/admin/assets/css/plugins.min.css" />
    <link rel="stylesheet" href="/template/admin/assets/css/kaiadmin.min.css" />
</head>
<body>
  <p> *** Bạn có 1 đơn hàng từ MULTI SHOP.</p>
  <p> + Cảm ơn bạn đã mua sản phẩm trên hệ thống của chúng tôi!</p>
  <p>THÔNG TIN ĐƠN HÀNG CỦA BẠN:</p>
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
      <?php $total_price = 0;
          $count = 0;
      ?>
        @foreach ($cart as $key => $detail)
        <?php 
          $total_price += $detail['quantity'] * $detail['price'];
          $count += 1;
        ?>
          <tr>
              <td> {{ $count }}</td>
              <td>{{ $detail['name'] }}</td> 
              <td><img src="{{ asset('uploads/products/' . $detail['image']) }}" alt="{{ $detail['name'] }}" width="50"></td>
              <td>{{ number_format($detail['price']) }}đ</td>
              <td>{{ $detail['quantity'] }}</td>
              <td>{{ number_format($detail['quantity'] * $detail['price']) }}đ</td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div>
        <div>
          <p class="text-right"><span class="fw-bold">   ~~~ Tạm tính:</span> {{ number_format($total_price) }}đ</p>
          <p class="text-right"><span class="fw-bold">   ~~~ Phí vận chuyển:</span>10.000đ</p>
          <p class="text-right"><span class="fw-bold">   ~~~ TỔNG TIỀN:</span> {{ number_format($total_price + 10000) }}đ</p>                                  
        </div>
    </div>
  <p>Hệ thống đã tạo tự động cho bạn 1 tài khoản để bạn có thể đăng nhập vào hệ thống của chúng tôi:</p>
  <p>THÔNG TIN CỦA BẠN:</p>
  <ul>
      <li>Tên người dùng: {{ $name }}</li>
      <li>Email: {{ $email }}</li>
      <li>Số điện thoại: {{ $phone }}</li>
      <li>Địa chỉ: {{ $address }}</li>
  </ul>

  <p>TÀI KHOẢN ĐỂ ĐĂNG NHẬP VÀO HỆ THỐNG:</p>
  <ul>
      <li>Email: {{ $email }}</li>
      <li>Password: {{ $rand }}</li>
  </ul>
  <p>Vui lòng không cung cấp cho bất kỳ ai thông tin tài khoản của bạn để tránh gặp các vấn đề ngoài ý muốn.</p>
  <p>Nếu có bất kỳ thắc mắc gì -> Liên hệ chúng tôi <a href="mailto:tienlevan78py@gmail.com">Contact us</a></p>

</body>
</html>