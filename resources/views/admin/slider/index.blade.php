@extends('admin.layout_admin.main')

@section('content')
    <div class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
              <li class="breadcrumb-item active" aria-current="page">Sliders</li>
            </ol>
        </nav>
        <a href="{{ route('sliders.create') }}" class="btn btn-success text-right">Thêm mới slider</a>
    </div>
    <div class="container">
        @include('admin.layout_admin.alert')
    </div>
    @if($sliders -> isNotEmpty())
    <table class="table table-content table-responsive  table-bordered table-head-bg-info table-bordered-bd-info text-center">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Slug</th>
            <th scope="col">Image</th>
            <th scope="col">Description</th>
            <th scope="col">Active</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($sliders as $va)
                <tr>
                <th scope="row">{{ $va -> id }}</th>
                <td>{{ $va -> name }}</td>
                <td>{{ $va -> slug }}</td>
                <td><img src="/uploads/sliders/{{ $va -> image }}" alt="{{ $va -> name }}" width="40"></td>
                <td>{!! $va -> description !!}</td>
                <td>{!! \App\Helper\Helper::active($va -> active) !!}</td>
                <td>
                    <a href="{{ route('sliders.edit', $va -> id) }}" class="btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('sliders.destroy', $va -> id) }}" method="POST" style="display: inline">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Bạn có chắc chắn muốn xóa slider này?')"><i class="fas fa-trash"></i></button>
                      </form>
                </td>
                </tr>
            @endforeach
        </tbody>
      </table>
      {{ $sliders -> links() }}
    @else 
    <table class="table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Slug</th>
            <th scope="col">Image</th>
            <th scope="col">Description</th>
            <th scope="col">Active</th>
          </tr>
        </thead>
        <tbody >
            <p class="text-center text-danger">Không có sliders nào!</p>
        </tbody>
      </table>
    @endif
@endsection