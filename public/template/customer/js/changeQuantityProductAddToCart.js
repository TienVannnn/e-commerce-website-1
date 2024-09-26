$(document).ready(function () {
    // Lắng nghe sự kiện khi thay đổi giá trị input
    $(".quantity-product").on("change", function () {
        let quantityInput = $(this);
        let maxQuantity = parseInt(quantityInput.data("quantity-max")); // Lấy số lượng tồn kho
        let currentQuantity = parseInt(quantityInput.val());

        // Kiểm tra nếu số lượng nhập lớn hơn số lượng tồn kho
        if (currentQuantity > maxQuantity) {
            toastr.error(
                "Số lượng sản phẩm không được vượt quá " + maxQuantity,
                "Lỗi"
            );
            quantityInput.val(maxQuantity); // Đặt lại giá trị về số lượng tồn kho tối đa
        }
    });

    // Xử lý khi nhấn nút tăng số lượng
    $(".btn-pluss").click(function () {
        let quantityInput = $(this)
            .closest(".quantityy")
            .find(".quantity-product");
        let maxQuantity = parseInt(quantityInput.data("quantity-max"));
        let currentQuantity = parseInt(quantityInput.val());

        // Kiểm tra nếu số lượng mới sẽ vượt quá số lượng tồn kho
        if (currentQuantity < maxQuantity) {
            quantityInput.val(currentQuantity + 1);
        } else {
            toastr.warning(
                "Sản phẩm này hiện chỉ còn " + maxQuantity + " số lượng",
                "Cảnh báo"
            );
        }
    });

    // Xử lý khi nhấn nút giảm số lượng
    $(".btn-minuss").click(function () {
        let quantityInput = $(this)
            .closest(".quantityy")
            .find(".quantity-product");
        let currentQuantity = parseInt(quantityInput.val());

        if (currentQuantity > 1) {
            quantityInput.val(currentQuantity - 1);
        }
    });
});
