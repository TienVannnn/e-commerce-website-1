@extends('admin.layout_admin.main')

@section('css')
    <link rel="stylesheet" href="/template/admin/assets/css/roles/roles.css">
@endsection

@section('js')
    <script src="/template/admin/assets/js/role/role.js"></script>
@endsection

@section('content')
  <a href="{{ route('roles.index') }}" name="back" class="btn btn-outline-danger back"> <i class="fas fa-angle-left"></i> Back</a>
            <div class="card">
                <div class="card-header" style="background: skyblue">{{ $title }}</div>
                @include('admin.layout_admin.alert')
                <div class="card-body">
                    <form method="POST" action="{{ route('roles.store') }}"> 
                        @csrf
                        <div class="mb-3">
                          <label for="name" class="form-label">Name</label>
                          <input type="text" class="form-control"  id="name" name="name" value="{{ old('name') }}" placeholder="Enter name">
                        </div>
                        <div class="mb-3">
                            <label for="display" class="form-label">Description</label>
                            <input type="text" class="form-control" id="display" name="description" value="{{ old('description') }}" placeholder="Enter description">
                          </div>
                          <div class="mb-3">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input checkbox-childrent check-all"type="checkbox" id="checkall">
                              <label class="form-check-label" for="checkall">Check all</label>
                            </div>
                          </div>
                          @foreach ($permissionParent as $va)
                            <div class="mb-3 module-parent">
                              <div class="form-check bg-success-gradient form-custom">
                                <input id="module{{ $va -> id }}" type="checkbox" value="" class="form-check-input checkbox-parent">
                                <label class="form-check-label" for="module{{ $va -> id }}" id="lable-module">{{ $va -> name }}</label>
                              </div>
                              <div class="text-center">
                              @foreach ($va -> permissionChildrent as $item)
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input checkbox-childrent" name="permission_id[]" type="checkbox" id="module{{ $va -> id }}-{{ $item -> id }}" value="{{ $item -> id }}">
                                    <label class="form-check-label" for="module{{ $va -> id }}-{{ $item -> id }}">{{ $item -> name }}</label>
                                  </div>
                              @endforeach
                              </div>
                            </div>
                          @endforeach
                          <div class="mb-3">
                            <label>Active</label>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" value="1" type="radio" id="active1" name="active" checked="">
                                <label for="active1" class="custom-control-label">Yes</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" value="0" type="radio" id="no_active" name="active" >
                                <label for="no_active" class="custom-control-label">No</label>
                            </div>
                        </div>
                        <button type="submit" name="add" class="btn btn-primary">Add</button>
                      </form> 
                    
                </div>
            </div>
@endsection
