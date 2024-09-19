<!DOCTYPE html>
<html lang="en">
<head>
    @include('customer.layout.head')
    @yield('css')
</head>
<body>
    @include('customer.layout.header')
    @yield('content')
    @include('customer.layout.footer')
    @include('customer.layout.script')
    @yield('js')
</body>
</html>