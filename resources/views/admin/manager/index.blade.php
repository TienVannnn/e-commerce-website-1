@extends('admin.layout_admin.main')

@section('content')
    <div class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
              <li class="breadcrumb-item active" aria-current="page">Manager</li>
            </ol>
        </nav>
        <a href="{{ route('managers.create') }}" class="btn btn-success text-right">Add new manager</a>
    </div>
    <div class="container">
        @include('admin.layout_admin.alert')
    </div>
    @if($managers -> isNotEmpty())
    <table class="table table-content table-responsive  table-bordered table-head-bg-info table-bordered-bd-info text-center">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($managers as $va)
              <tr>
              <th scope="row">{{ $va -> id }}</th>
              <td>{{ $va -> name }}</td>
              <td>{{ $va -> email }}</td>
              <td>
                  <a href="{{ route('managers.edit', $va -> id) }}" class="btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                  <form action="{{ route('managers.destroy', $va -> id) }}" method="POST" style="display: inline">
                      @method('DELETE')
                      @csrf
                      <button class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Bạn có chắc chắn muốn xóa người này?')"><i class="fas fa-trash"></i></button>
                    </form>
              </td>
              </tr>
          @endforeach
      </tbody>
      </table>
      {{ $managers -> links() }}
    @else 
    <table class="table table-content table-responsive  table-bordered table-head-bg-info table-bordered-bd-info text-center">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody >
            <p class="text-center text-danger">Không có manager nào!</p>
        </tbody>
      </table>
    @endif
@endsection