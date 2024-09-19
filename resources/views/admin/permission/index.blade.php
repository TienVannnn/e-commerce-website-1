@extends('admin.layout_admin.main')

@section('content')
      <div class="content-header">
          <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
                <li class="breadcrumb-item active" aria-current="page">Permission</li>
              </ol>
          </nav>
          <a href="{{ route('permissions.create') }}" class="btn btn-success text-right">Add new permission</a>
      </div>
      <div class="container">
          @include('admin.layout_admin.alert')
      </div>
      @if($permissions -> isNotEmpty())
      <table class="table table-content table-responsive  table-bordered table-head-bg-info table-bordered-bd-info text-center">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Key code</th>
              <th scope="col">Parent</th>
              <th scope="col">Active</th>
              <th scope="col">Handle</th>
            </tr>
          </thead>
          <tbody>
                  {!! \App\Helper\Helper::permission($permissions) !!}
          </tbody>
        </table>
        {{ $permissions -> links() }}
      @else 
      <table class="table table-content table-responsive  table-bordered table-head-bg-info table-bordered-bd-info text-center">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Des</th>
              <th scope="col">Parent</th>
              <th scope="col">Active</th>
            </tr>
          </thead>
          <tbody >
              <p class="text-center text-danger">Không có quyền nào!</p>
          </tbody>
        </table>
      @endif
@endsection