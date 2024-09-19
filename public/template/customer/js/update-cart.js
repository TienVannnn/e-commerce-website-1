$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$(document).ready(function () {
    function updateTotalPrice(productId, price, quantity) {
        let total = price * quantity;
        $("#total-" + productId).text(
            new Intl.NumberFormat("vi-VN").format(total) + "đ"
        );
    }

    // Hàm cập nhật giỏ hàng qua AJAX
    function updateCart(productId, quantity) {
        $.ajax({
            url: "/update-cart/" + productId,
            type: "POST",
            data: {
                quantity: quantity,
            },
            success: function (response) {
                let price = response.price;
                let quantity = response.quantity;
                $("#subtotal").text(response.subtotal);
                $("#total-sumary").text(response.total);
                updateTotalPrice(productId, price, quantity);
                toastr.success("Cập nhật sản phẩm thành công", "Thành công");
            },
            error: function (error) {
                console.log("Error:", error);
            },
        });
    }

    // Xử lý khi nhấn nút tăng số lượng
    $(".btn-plus").click(function () {
        let productId = $(this).data("id");
        let quantityInput = $(".quantity-input[data-id='" + productId + "']");
        let quantity = parseInt(quantityInput.val());
        quantity++;
        quantityInput.val(quantity);
        updateCart(productId, quantity);
    });

    // Xử lý khi nhấn nút giảm số lượng
    $(".btn-minus").click(function () {
        let productId = $(this).data("id");
        let quantityInput = $(".quantity-input[data-id='" + productId + "']");
        let quantity = parseInt(quantityInput.val());
        if (quantity > 1) {
            quantity--;
            quantityInput.val(quantity);
            updateCart(productId, quantity);
        }
    });

    // Xử lý sự kiện khi nhấn vào nút "Xóa"
    $(document).on("click", ".btn-remove-product", function (e) {
        e.preventDefault();
        let url = $(this).data("url");
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            success: function (response) {
                if (response.status === 200) {
                    // Xóa dòng sản phẩm khỏi bảng giỏ hàng
                    $(e.target).closest("tr").remove();
                    // Cập nhật số lượng sản phẩm trong giỏ hàng
                    $(".count-carts").text(response.countCarts);
                    if (response.countCarts == 0) {
                        $(".checkout-row").remove();
                        $(".no-product-cart").html(
                            '<p class="text-center text-danger">Không có sản phẩm nào trong giỏ hàng của bạn!</p>'
                        );
                    }
                    $("#subtotal").text(response.subtotal);
                    $("#total-sumary").text(response.total);
                    // Hiển thị thông báo thành công
                    toastr.success(response.message, response.title);
                } else {
                    toastr.error(response.message, response.title);
                }
            },
            error: function (xhr, status, error) {
                console.log("Error: " + error);
            },
        });
    });
});
