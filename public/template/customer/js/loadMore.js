$(document).ready(function () {
    $("#show-all-reviews").click(function () {
        let id = $(this).data("id");
        url = route("load-more-reviews");

        $.ajax({
            url: url,
            type: "GET",
            data: {
                product_id: id,
            },
            success: function (data) {
                $("#all-reviews").html(data).show();
                $("#show-all-reviews").hide();
                $("#hide-reviews").show();
            },
            error: function (xhr, status, error) {
                alert("Đã xảy ra lỗi, vui lòng thử lại");
            },
        });
    });

    $("#hide-reviews").click(function () {
        $("#all-reviews").hide();
        $("#show-all-reviews").show();
        $(this).hide();
    });
});
