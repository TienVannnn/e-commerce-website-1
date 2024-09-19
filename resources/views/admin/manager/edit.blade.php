@extends('admin.layout_admin.main')

@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
  <a href="{{ route('managers.index') }}" name="back" class="btn btn-outline-danger back"> <i class="fas fa-angle-left"></i> Back</a>
            <div class="card">
                <div class="card-header" style="background: skyblue">{{ $title }}</div>
                @include('admin.layout_admin.alert')
                <div class="card-body">
                    <form method="POST" action="{{ route('managers.update', $manager -> id) }}"> 
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                          <label for="name" class="form-label">Name</label>
                          <input type="text" class="form-control" id="name" name="name" value="{{ $manager -> name }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $manager -> email }}">
                          </div>
                          <div class="mb-3">
                            <label for="pass" class="form-label">Password</label>
                            <input type="password" class="form-control" id="pass" name="password" value="{{ $manager -> password }}">
                          </div>
                          <div class="mb-3">
                            <label for="role" class="form-label">Roles</label>
                            <select class="form-control tag-select" multiple="multiple" name="roles[]" id="role">
                              @foreach ($roles as $va)
                                  <option value="{{ $va -> id }}" {{ $roles_managers -> contains('id', $va -> id) ? 'selected' : ''}}>{{ $va -> name }}</option>
                              @endforeach
                            </select>
                          </div>
                        <button type="submit" name="update" class="btn btn-warning">Update</button>
                      </form> 
                </div>
            </div>
@endsection

@section('js')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    $(function(){
      $('.tag-select').select2({
        placeholder: "Chọn vai trò"
      })
    })
  </script>
@endsection