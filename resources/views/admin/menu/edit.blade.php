@extends('admin.layout_admin.main')

@section('content')
  <a href="{{ route('menus.index') }}" name="back" class="btn btn-outline-danger back"> <i class="fas fa-angle-left"></i> Back</a>
            <div class="card">
                <div class="card-header" style="background: skyblue">{{ $title }}</div>
                @include('admin.layout_admin.alert')
                <div class="card-body">
                    <form method="POST" action="{{ route('menus.update', $menu -> id) }}" enctype="multipart/form-data"> 
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                          <label for="slug" class="form-label">Name</label>
                          <input type="text" class="form-control" onkeyup="ChangeToSlug()" id="slug" name="name" value="{{ $menu -> name }}">
                        </div>
                        <div class="mb-3">
                            <label for="convert_slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="convert_slug" name="slug" value="{{ $menu -> slug }}">
                          </div>
                          <div class="mb-3">
                            <label for="parent" class="form-label">Parent menu</label>
                            <select name="parent_id" id="parent" class="form-select">
                                <option value="0" {{ $menu -> parent_id == 0 ? 'selected' : '' }}>Parent menu</option>
                                {!! $htmlOptions !!}
                            </select>
                          </div>
                          <div class="mb-3">
                            <label>Active</label>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" value="1" type="radio" id="active1" name="active" checked=""
                                {{ $menu -> active == 1 ? 'checked' : '' }}>
                                <label for="active1" class="custom-control-label">Yes</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" value="0" type="radio" id="no_active" name="active" 
                                {{ $menu -> active == 0 ? 'checked' : '' }}>
                                <label for="no_active" class="custom-control-label">No</label>
                            </div>
                        </div>
                        
                        <button type="submit" name="update" class="btn btn-warning">Update</button>
                      </form> 
                    
                </div>
            </div>
@endsection