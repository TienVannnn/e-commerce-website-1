// $.ajaxSetup({
//     headers: {
//         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//     },
// });

$(document).ready(function () {
    $("#price-all").on("change", function () {
        if ($(this).is(":checked")) {
            // Nếu "Tất cả giá tiền" được chọn, bỏ chọn các checkbox khác
            $(".custom-control-input").not(this).prop("checked", false);
        }
        filterProducts();
    });

    $(".custom-control-input")
        .not("#price-all")
        .on("change", function () {
            if ($(this).is(":checked")) {
                // Nếu một checkbox giá nào đó được chọn, bỏ chọn "Tất cả giá tiền"
                $("#price-all").prop("checked", false);
            }
            filterProducts();
        });

    function filterProducts() {
        let prices = [];
        var categoryId = $("#category-id").val();
        if ($("#price-all").is(":checked")) {
            // Nếu tất cả giá tiền được chọn, không gửi điều kiện giá
            prices = null;
        } else {
            // Lấy các khoảng giá đã chọn
            if ($("#price-1").is(":checked")) {
                prices.push({ min: 0, max: 500000 });
            }
            if ($("#price-2").is(":checked")) {
                prices.push({ min: 500000, max: 5000000 });
            }
            if ($("#price-3").is(":checked")) {
                prices.push({ min: 5000000, max: 50000000 });
            }
            if ($("#price-2").is(":checked")) {
                prices.push({ min: 50000000, max: 50000000000 });
            }
        }

        // Gửi yêu cầu AJAX với dữ liệu đã lọc
        $.ajax({
            url: "/filter-products",
            method: "POST",
            data: {
                prices: prices,
                category_id: categoryId, // ID danh mục hiện tại
            },
            success: function (response) {
                // Cập nhật sản phẩm hiển thị
                $("#product-list").html(response);
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText); // Log lỗi để kiểm tra
            },
        });
    }
});
