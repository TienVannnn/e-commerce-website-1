@extends('admin.layout_admin.main')

@section('content')
    <div class="content-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/admin">Admin</a></li>
              <li class="breadcrumb-item active" aria-current="page">Menu</li>
            </ol>
        </nav>
        <a href="{{ route('menus.create') }}" class="btn btn-success text-right">Add new menu</a>
    </div>
    <div class="container">
        @include('admin.layout_admin.alert')
    </div>
    @if($menus -> isNotEmpty())
    <table class="table table-content table-responsive  table-bordered table-head-bg-info table-bordered-bd-info text-center">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Slug</th>
            <th scope="col">Parent</th>
            <th scope="col">Active</th>
            <th scope="col">Handle</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($menus as $va)
                {!! \App\Helper\Helper::menu($menus) !!}
            @endforeach
        </tbody>
      </table>
      {{ $menus -> links() }}
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
            <p class="text-center text-danger">Không có menu nào!</p>
        </tbody>
      </table>
    @endif
@endsection