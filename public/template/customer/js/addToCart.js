function addToCart(e) {
    e.preventDefault();
    let url = $(this).data("url");
    $.ajax({
        url: url,
        type: "GET",
        dataType: "JSON",
        success: function (res) {
            $(".count-carts").text(res.countCarts);
            if (res.status == 200) {
                toastr.success(res.message, res.title);
            }
        },
        error: function (xhr, status, error) {
            toastr.error("Thêm sản phẩm vào giỏ hàng lỗi", "Thất bại");
            console.log("Error details:");
            console.log("Status: " + status);
            console.log("Error: " + error);
            console.log("Response Text: " + xhr.responseText);
        },
    });
}

function addToCartWithQuantity(e) {
    e.preventDefault();
    let url = $(this).data("url");
    let quantity = $(".quantity-product").val();
    $.ajax({
        url: url,
        type: "GET",
        dataType: "JSON",
        data: {
            quantity: quantity,
        },
        success: function (res) {
            $(".count-carts").text(res.countCarts);
            if (res.status == 200) {
                toastr.success(res.message, res.title);
            }
        },
        error: function (xhr, status, error) {
            toastr.error("Thêm sản phẩm vào giỏ hàng lỗi", "Thất bại");
            console.log("Error details:");
            console.log("Status: " + status);
            console.log("Error: " + error);
            console.log("Response Text: " + xhr.responseText);
        },
    });
}
$(".addToCart").on("click", addToCart);
$(".addToCartWithQuantity").on("click", addToCartWithQuantity);
