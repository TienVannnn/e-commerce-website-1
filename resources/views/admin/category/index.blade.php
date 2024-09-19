@extends('admin.layout_admin.main')

@section('content')
    <div class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
              <li class="breadcrumb-item active" aria-current="page">Category</li>
            </ol>
        </nav>
        <a href="{{ route('category.create') }}" class="btn btn-success text-right">Add new category</a>
    </div>
    <div class="container">
        @include('admin.layout_admin.alert')
    </div>
    @if($categories -> isNotEmpty())
    <table class="table table-content table-responsive  table-bordered table-head-bg-info table-bordered-bd-info text-center">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Slug</th>
            <th scope="col">Image</th>
            <th scope="col">Parent</th>
            <th scope="col">Active</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>
                {{-- {!! \App\Helper\Helper::category($categories) !!} --}}
                @foreach ($categories as $menu)
                  <tr>
                    <td> {{ $menu->id }}</td>
                    <td>{{ $menu->name }}</td>
                    <td>{{ $menu->slug }}</td>
                    <td> <img src="/uploads/category/{{ $menu->img }}" width ="50"/></td>
                    <td>{{ $menu -> parent ? $menu -> parent -> name : 'Parent' }}</td>
                    <td>{!! \App\Helper\Helper::active($menu->active) !!}</td>
                    <td>
                        <a href="{{ route('category.edit', $menu -> id) }}" class="btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('category.destroy', $menu -> id) }}" method="POST" style="display: inline">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this category?')"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
        </tbody>
      </table>
      {{ $categories -> links() }}
    @else 
    <table class="table table-content table-responsive  table-bordered table-head-bg-info table-bordered-bd-info text-center">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Slug</th>
            <th scope="col">Parent</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody >
            <p class="text-center text-danger">Không có danh mục nào!</p>
        </tbody>
      </table>
    @endif
@endsection