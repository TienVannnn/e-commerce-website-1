@extends('admin.layout_admin.main')

@section('content')
    <div class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
              <li class="breadcrumb-item active" aria-current="page">Config</li>
            </ol>
        </nav>
        <a href="{{ route('configs.create') }}" class="btn btn-success text-right">Add new config</a>
    </div>
    <div class="container">
        @include('admin.layout_admin.alert')
    </div>
    @if($configs -> isNotEmpty())
    <table class="table table-content table-responsive  table-bordered table-head-bg-info table-bordered-bd-info text-center">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Key</th>
            <th scope="col">Value</th>
            <th scope="col">Active</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($configs as $va)
              <tr>
              <th scope="row">{{ $va -> id }}</th>
              <td>{{ $va -> key }}</td>
              <td>{{ $va -> value }}</td>
              <td>{!! \App\Helper\Helper::active($va -> active) !!}</td>
              <td>
                  <a href="{{ route('configs.edit', $va -> id) }}" class="btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                  <form action="{{ route('configs.destroy', $va -> id) }}" method="POST" style="display: inline">
                      @method('DELETE')
                      @csrf
                      <button class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Bạn có chắc chắn muốn xóa config này?')"><i class="fas fa-trash"></i></button>
                    </form>
              </td>
              </tr>
          @endforeach
      </tbody>
      </table>
      {{ $configs -> links() }}
    @else 
    <table class="table table-content table-responsive  table-bordered table-head-bg-info table-bordered-bd-info text-center">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Key</th>
            <th scope="col">Value</th>
            <th scope="col">Active</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody >
            <p class="text-center text-danger">Không có config nào!</p>
        </tbody>
      </table>
    @endif
@endsection