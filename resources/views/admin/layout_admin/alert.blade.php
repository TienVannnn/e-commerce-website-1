@if ($errors->any())
    <div class="alert alert-danger auto-hide">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger auto-hide">
        {{ Session::get('error') }}
    </div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success auto-hide">
        {{ Session::get('success') }}
    </div>
@endif
