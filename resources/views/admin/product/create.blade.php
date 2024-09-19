@extends('admin.layout_admin.main')

@section('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
  <a href="{{ route('products.index') }}" name="back" class="btn btn-outline-danger back"> <i class="fas fa-angle-left"></i> Back</a>
            <div class="card">
                <div class="card-header" style="background: skyblue">{{ $title }}</div>
                @include('admin.layout_admin.alert')
                <div class="card-body">
                    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data"> 
                        @csrf
                        <div class="mb-3">
                          <label for="code" class="form-label">Code</label>
                          <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" placeholder="Enter product code">
                        </div>
                        <div class="mb-3">
                          <label for="slug" class="form-label">Name</label>
                          <input type="text" class="form-control" onkeyup="ChangeToSlug()" id="slug" name="name" value="{{ old('name') }}" placeholder="Enter product name">
                        </div>
                        <div class="mb-3">
                            <label for="convert_slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="convert_slug" name="slug" value="{{ old('slug') }}" placeholder="Enter product slug">
                        </div>
                        <div class="mb-3">
                          <label for="price" class="form-label">Price</label>
                          <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" placeholder="Enter product price">
                        </div>
                        <div class="mb-3">
                          <label for="image" class="form-label">Image</label>
                          <input type="file" class="form-control" id="image" name="image" value="{{ old('image') }}">
                        </div>
                        <div class="mb-3">
                          <label for="image_detail" class="form-label">Image Detail</label>
                          <input type="file" multiple class="form-control" id="image_detail" name="image_detail[]">
                          <div id="image_preview" class="mt-3"></div>
                        </div>
                        <div class="mb-3">
                          <label for="tag" class="form-label">Tag</label>
                          <select class="form-control tag-select" multiple="multiple" name="tags[]" id="tag">
                          </select>
                        </div>
                        <div class="mb-3">
                          <label for="quantity" class="form-label">Quantity</label>
                          <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity') }}" placeholder="Enter product quantity">
                        </div>
                        <div class="mb-3">
                            <label for="parent" class="form-label">Category</label>
                            <select name="category_id" id="parent" class="form-select category-select">
                              @foreach ($category as $va)
                                <option value="{{ $va -> id }}">{{ $va -> name }}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                          <label for="des" class="form-label">Short Des</label>
                          <input type="text" class="form-control" id="des" name="short_des" value="{{ old('short_des') }}" placeholder="Enter a short product description">
                        </div>
                        <div class="mb-3">
                          <label for="content" class="form-label">Content</label>
                          <textarea name="content" id="content" cols="30" rows="10">{{ old('content') }}</textarea>
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

@section('js')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="{{ asset('template/admin/assets/js/product/product.js') }}"></script>
@endsection