@extends('admin.layout_admin.main')

@section('content')
    <div class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
              <li class="breadcrumb-item active" aria-current="page">Search product</li>
            </ol>
        </nav>
        <a href="{{ route('products.create') }}" class="btn btn-success text-right">Add new product</a>
    </div>
    <div class="container">
        <h3>Kết quả tìm kiếm cho từ khóa: "{{ $text }}"</h3>
    </div>
    <div class="container">
        @include('admin.layout_admin.alert')
    </div>
    @if($products -> isNotEmpty())
    <table class="table table-content table-responsive  table-bordered table-head-bg-info table-bordered-bd-info text-center">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Image</th>
            <th scope="col">Quan</th>
            <th scope="col">Category</th>
            <th scope="col">Active</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($products as $va)
            <tr>
                <td scope="col">{{ $va -> id }}</td>
                <td scope="col">{{ $va -> name }}</td>
                <td scope="col">{{ number_format($va -> price) }}đ</td>
                <td scope="col"><img src="/uploads/products/{{ $va -> image }}" alt="{{ $va -> name }}" width="50"></td>
                <td scope="col">{{ $va -> quantity }}</td>
                <td scope="col">{{ $va -> category -> name }}</td>
                <td scope="col">{!! \App\Helper\Helper::active($va -> active) !!}</td>
                <td scope="col">
                  <a href="{{ route('products.edit', $va -> id) }}" title="Edit" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                  <form action="{{ route('products.destroy', $va -> id) }}" method="POST" style="display: inline">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')"><i class="fas fa-trash"></i></button>
                  </form>
                </td>
              </tr>
            @endforeach
        </tbody>
      </table>
      {{ $products -> onEachSide(1) -> links() }}
    @else 
    <table class="table table-content table-responsive  table-bordered table-head-bg-info table-bordered-bd-info text-center">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Price</th>
            <th scope="col">Image</th>
            <th scope="col">Tag</th>
            <th scope="col">Quantity</th>
            <th scope="col">Category</th>
            <th scope="col">Active</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody >
            <p class="text-center text-danger">Không có sản phẩm nào trùng với từ khóa "{{ $text }}"!</p>
        </tbody>
      </table>
    @endif
@endsection