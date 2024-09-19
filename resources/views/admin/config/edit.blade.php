@extends('admin.layout_admin.main')

@section('content')
  <a href="{{ route('configs.index') }}" name="back" class="btn btn-outline-danger back"> <i class="fas fa-angle-left"></i> Back</a>
            <div class="card">
                <div class="card-header" style="background: skyblue">{{ $title }}</div>
                @include('admin.layout_admin.alert')
                <div class="card-body">
                    <form method="POST" action="{{ route('configs.update', $config -> id) }}" enctype="multipart/form-data"> 
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                          <label for="key" class="form-label">Key</label>
                          <input type="text" class="form-control" id="key" name="key" value="{{ $config -> key }}">
                        </div>
                        <div class="mb-3">
                            <label for="value" class="form-label">Value</label>
                            <input type="text" class="form-control" id="value" name="value" value="{{ $config -> value }}">
                          </div>
                          <div class="mb-3">
                            <label>Active</label>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" value="1" type="radio" id="active1" name="active" checked=""
                                {{ $config -> active == 1 ? 'checked' : '' }}>
                                <label for="active1" class="custom-control-label">Yes</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" value="0" type="radio" id="no_active" name="active" 
                                {{ $config -> active == 0 ? 'checked' : '' }}>
                                <label for="no_active" class="custom-control-label">No</label>
                            </div>
                        </div>
                        
                        <button type="submit" name="update" class="btn btn-warning">Update</button>
                      </form> 
                    
                </div>
            </div>
@endsection