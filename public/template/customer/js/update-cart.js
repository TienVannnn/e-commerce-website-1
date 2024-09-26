$(document).ready(function () {
    function updateTotalPrice(productId, price, quantity) {
        let total = price * quantity;
        $("#total-" + productId).text(
            new Intl.NumberFormat("vi-VN").format(total) + "đ"
        );
    }

    // Hàm cập nhật giỏ hàng qua AJAX
    function updateCart(productId, quantity, callback) {
        $.ajax({
            url: "/update-cart/" + productId,
            type: "POST",
            data: {
                quantity: quantity,
            },
            success: function (response) {
                // Gọi callback khi cập nhật giỏ hàng thành công
                if (typeof callback === "function") {
                    callback(true, response);
                }
            },
            error: function (error) {
                // Gọi callback khi có lỗi
                if (typeof callback === "function") {
                    callback(false, error.responseJSON);
                }
            },
        });
    }

    // Xử lý khi nhấn nút tăng số lượng
    $(".btn-plus").click(function () {
        let productId = $(this).data("id");
        let quantityInput = $(".quantity-input[data-id='" + productId + "']");
        let currentQuantity = parseInt(quantityInput.val());
        let newQuantity = currentQuantity + 1;

        // Gọi updateCart với số lượng mới và chờ phản hồi từ server
        updateCart(productId, newQuantity, function (success, response) {
            if (success) {
                // Nếu không có lỗi, cập nhật giá trị input và tổng giá
                quantityInput.val(newQuantity);
                let price = response.price;
                let quantity = response.quantity;
                $("#subtotal").text(response.subtotal);
                $("#total-sumary").text(response.total);
                updateTotalPrice(productId, price, quantity);
                toastr.success("Cập nhật sản phẩm thành công", "Thành công");
            } else {
                // Nếu có lỗi, hiển thị thông báo lỗi và không cập nhật giá trị input
                toastr.error(response.error, "Lỗi");
            }
        });
    });

    // Xử lý khi nhấn nút giảm số lượng
    $(".btn-minus").click(function () {
        let productId = $(this).data("id");
        let quantityInput = $(".quantity-input[data-id='" + productId + "']");
        let currentQuantity = parseInt(quantityInput.val());
        let newQuantity = currentQuantity - 1;

        if (newQuantity > 0) {
            // Gọi updateCart với số lượng mới và chờ phản hồi từ server
            updateCart(productId, newQuantity, function (success, response) {
                if (success) {
                    // Nếu không có lỗi, cập nhật giá trị input và tổng giá
                    quantityInput.val(newQuantity);
                    let price = response.price;
                    let quantity = response.quantity;
                    $("#subtotal").text(response.subtotal);
                    $("#total-sumary").text(response.total);
                    updateTotalPrice(productId, price, quantity);
                    toastr.success(
                        "Cập nhật sản phẩm thành công",
                        "Thành công"
                    );
                } else {
                    // Nếu có lỗi, hiển thị thông báo lỗi và không cập nhật giá trị input
                    toastr.error(response.error, "Lỗi");
                }
            });
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
