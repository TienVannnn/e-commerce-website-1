<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="/template/customer/lib/easing/easing.min.js"></script>
<script src="/template/customer/lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Contact Javascript File -->
<script src="/template/customer/mail/jqBootstrapValidation.min.js"></script>
<script src="/template/customer/mail/contact.js"></script>

<!-- Template Javascript -->
<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
<script src="/template/customer/js/main.js"></script>
<script src="/template/customer/js/addToCart.js">
</script>
<script src="/template/customer/js/addFavoriteProduct.js"></script>

<script>
    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}", "Thất bại");
    @endif
    
    @if(Session::has('success-cart'))
        toastr.success("{{ Session::get('success-cart') }}", "Thành công");
        {{ Session::forget('success-cart') }}
    @endif

    @if(Session::has('error-login'))
        toastr.error("{{ Session::get('error-login') }}", "Thất bại");
    @endif

    @if(Session::has('success-register'))
        toastr.success("{{ Session::get('success-register') }}", "Thành công");
    @endif

    @if(Session::has('success-login'))
        toastr.success("{{ Session::get('success-login') }}", "Thành công");
    @endif

    @if(Session::has('success-logout'))
        toastr.success("{{ Session::get('success-logout') }}", "Thành công");
    @endif

    @if(Session::has('success-editaccount'))
        toastr.success("{{ Session::get('success-editaccount') }}", "Thành công");
    @endif

    @if(Session::has('success-changePass'))
        toastr.success("{{ Session::get('success-changePass') }}", "Thành công");
    @endif

    @if(Session::has('error-changePass'))
        toastr.error("{{ Session::get('error-changePass') }}", "Thành công");
    @endif
</script>