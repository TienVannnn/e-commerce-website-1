function addFavoriteProduct(e) {
    e.preventDefault();
    let url = $(this).data("url");
    $.ajax({
        url: url,
        type: "GET",
        dataType: "JSON",
        success: function (res) {
            if (res.status == 200) {
                toastr.success(res.message, res.title);
            }
        },
        error: function (xhr, status, error) {
            if (xhr.status == 401) {
                toastr.error(
                    "Bạn cần đăng nhập để thực hiện thao tác này",
                    "Lỗi"
                );
            } else if (xhr.status == 409) {
                toastr.warning(
                    "Sản phẩm đã có trong danh sách yêu thích",
                    "Cảnh báo"
                );
            } else {
                toastr.error("Thêm sản phẩm yêu thích lỗi", "Thất bại");
            }
            console.log("Error details:");
            console.log("Status: " + status);
            console.log("Error: " + error);
            console.log("Response Text: " + xhr.responseText);
        },
    });
}

$(".addFavoriteProduct").on("click", addFavoriteProduct);
