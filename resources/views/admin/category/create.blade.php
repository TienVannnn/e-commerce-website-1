@extends('admin.layout_admin.main')

@section('content')
  <a href="{{ route('category.index') }}" name="back" class="btn btn-outline-danger back"> <i class="fas fa-angle-left"></i> Back</a>
            <div class="card">
                <div class="card-header" style="background: skyblue">{{ $title }}</div>
                @include('admin.layout_admin.alert')
                <div class="card-body">
                    <form method="POST" action="{{ route('category.store') }}" enctype="multipart/form-data"> 
                        @csrf
                        <div class="mb-3">
                          <label for="slug" class="form-label">Name</label>
                          <input type="text" class="form-control" onkeyup="ChangeToSlug()" id="slug" name="name" value="{{ old('name') }}" placeholder="Enter name category">
                        </div>
                        <div class="mb-3">
                            <label for="convert_slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="convert_slug" name="slug" value="{{ old('slug') }}">
                          </div>
                          <div class="mb-3">
                            <input type="file" class="form-control" id="img" name="img">
                          </div>
                          <div class="mb-3">
                            <label for="parent" class="form-label">Parent Category</label>
                            <select name="parent_id" id="parent" class="form-select">
                                <option value="0">Parent Category</option>
                                {!! $htmlOptions !!}
                                {{-- @foreach ($categories as $va)
                                    <option value="{{ $va -> id }}">{{ $va -> name }}</option> 
                                @endforeach --}}
                            </select>
                          </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Description</label>
                            <textarea name="description" id="content"class="form-control" cols="30" rows="10">{{ old('description') }}</textarea>
                          </div>
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