@extends('admin.layout_admin.main')

@section('content')
    <div class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
              <li class="breadcrumb-item active" aria-current="page">Role</li>
            </ol>
        </nav>
        <a href="{{ route('roles.create') }}" class="btn btn-success text-right">Add new role</a>
    </div>
    <div class="container">
        @include('admin.layout_admin.alert')
    </div>
    @if($roles -> isNotEmpty())
    <table class="table table-content table-responsive  table-bordered table-head-bg-info table-bordered-bd-info text-center">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Active</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($roles as $va)
              <tr>
              <th scope="row">{{ $va -> id }}</th>
              <td>{{ $va -> name }}</td>
              <td>{{ $va -> description }}</td>
              <td scope="col">{!! \App\Helper\Helper::active($va -> active) !!}</td>
              <td>
                  <a href="{{ route('roles.edit', $va -> id) }}" class="btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                  <form action="{{ route('roles.destroy', $va -> id) }}" method="POST" style="display: inline">
                      @method('DELETE')
                      @csrf
                      <button class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Bạn có chắc chắn muốn xóa vai trò này?')"><i class="fas fa-trash"></i></button>
                    </form>
              </td>
              </tr>
          @endforeach
      </tbody>
      </table>
      {{ $roles -> links() }}
    @else 
    <table class="table table-content table-responsive  table-bordered table-head-bg-info table-bordered-bd-info text-center">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Active</th>
          </tr>
        </thead>
        <tbody >
            <p class="text-center text-danger">Không có role nào!</p>
        </tbody>
      </table>
    @endif
@endsection