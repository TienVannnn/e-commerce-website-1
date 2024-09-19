@extends('customer.layout.main')

@section('css')
    <link rel="stylesheet" href="/template/customer/css/custom.css">
@endsection

@section('js')
    <script src="/template/customer/js/overview.js"></script>
@endsection

@section('content')
@include('customer.layout.breadcrum')
    <div class="container-fluid">
        <div class="row px-xl-5">
            @include('customer.customer_overview.sidebar_overview') 
            <div class="col-lg-9 col-md-8 d-flex justify-content-center">
                <div class="row pb-3">
                    @yield('content-customer')
                </div>
            </div>
        </div>
    </div>
@endsection