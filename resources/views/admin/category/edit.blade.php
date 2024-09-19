@extends('admin.layout_admin.main')

@section('content')
  <a href="{{ route('category.index') }}" name="back" class="btn btn-outline-danger back"> <i class="fas fa-angle-left"></i> Back</a>
            <div class="card">
                <div class="card-header" style="background: skyblue">{{ $title }}</div>
                @include('admin.layout_admin.alert')
                <div class="card-body">
                    <form method="POST" action="{{ route('category.update', $category -> id) }}" enctype="multipart/form-data"> 
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                          <label for="slug" class="form-label">Name</label>
                          <input type="text" class="form-control" onkeyup="ChangeToSlug()" id="slug" name="name" value="{{ $category -> name }}">
                        </div>
                        <div class="mb-3">
                            <label for="convert_slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="convert_slug" name="slug" value="{{ $category -> slug }}">
                          </div>
                          <div class="mb-3">
                            <input type="file" class="form-control" id="img" name="img">
                            <img src="/uploads/category/{{ $category -> img }}" alt="img" width="50">
                          </div>
                          <div class="mb-3">
                            <label for="parent" class="form-label">Parent Category</label>
                            <select name="parent_id" id="parent" class="form-select">
                                <option value="0" {{ $category -> parent_id == 0 ? 'selected' : '' }}>Parent Category</option>
                                {!! $htmlOptions !!}
                                {{-- @foreach ($categories as $va)
                                    <option value="{{ $va -> id }}" {{ $category -> parent_id === $va -> id ? 'selected' : '' }}>{{ $va -> name }}</option> 
                                @endforeach --}}
                            </select>
                          </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Description</label>
                            <textarea name="description" id="content"class="form-control" cols="30" rows="10">{{ $category -> description }}</textarea>
                          </div>
                          <div class="mb-3">
                            <label>Active</label>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" value="1" type="radio" id="active1" name="active" checked=""
                                {{ $category -> active == 1 ? 'checked' : '' }}>
                                <label for="active1" class="custom-control-label">Yes</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" value="0" type="radio" id="no_active" name="active" 
                                {{ $category -> active == 0 ? 'checked' : '' }}>
                                <label for="no_active" class="custom-control-label">No</label>
                            </div>
                        </div>
                        
                        <button type="submit" name="update" class="btn btn-warning">Update</button>
                      </form> 
                    
                </div>
            </div>
@endsection