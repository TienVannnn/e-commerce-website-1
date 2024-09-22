$(document).ready(function () {
    function productHtml(product) {
        return `
            <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="/uploads/products/${
                            product.image
                        }" alt="" style="height: 326px">
                        <div class="product-action">
                            <a title="Thêm sản phẩm này vào giỏ hàng" class="btn btn-outline-dark btn-square addToCart" data-url="${route(
                                "addToCart",
                                { id: product.id }
                            )}">
                                <i class="fa fa-shopping-cart"></i>
                            </a>
                            <a title="Thích sản phẩm này" class="btn btn-outline-dark btn-square addFavoriteProduct" data-url="${route(
                                "addFavoriteProduct",
                                { id: product.id }
                            )}">
                                <i class="far fa-heart"></i>
                            </a>
                            <a class="btn btn-outline-dark btn-square" href="">
                                <i class="fa fa-sync-alt"></i>
                            </a>
                            <a class="btn btn-outline-dark btn-square" href="">
                                <i class="fa fa-search"></i>
                            </a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href="${route(
                            "product-c",
                            { slug: product.slug }
                        )}">${product.name}</a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>${formatPrice(
                                product.price
                            )}</h5><h6 class="text-muted ml-2"><del>${formatPrice(product.price)}</del></h6>
                        </div>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small>(99)</small>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    function filterProducts() {
        let selectedPrices = [];
        let category_id = $("#priceFilterForm").data("category");

        if ($("#price-all").is(":checked")) {
            selectedPrices = []; // Nếu chọn "All Price", không thêm giá vào mảng
        } else {
            $('#priceFilterForm input[type="checkbox"]:checked').each(
                function () {
                    if ($(this).attr("id") !== "price-all") {
                        selectedPrices.push($(this).val());
                    }
                }
            );
        }

        $.ajax({
            url: "/filter-products",
            method: "GET",
            dataType: "json",
            data: {
                price_range: selectedPrices,
                category_id: category_id,
                sort: selectedSort,
                limit: selectedLimit,
            },
            success: function (response) {
                toastr.success(response.message, "Thành công");
                $(".row.pb-3").empty();
                if (response.products.data.length > 0) {
                    response.products.data.forEach(function (product) {
                        let html = productHtml(product);
                        $(".row.pb-3").append(html);
                    });
                } else {
                    $(".row.pb-3").html(
                        "<p>Không có sản phẩm nào phù hợp.</p>"
                    );
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                toastr.error("Lọc sản phẩm lỗi", "Lỗi");
            },
        });
    }

    let selectedSort = "Latest";
    let selectedLimit = 9;

    $(".dropdown-item[data-sort]").click(function (e) {
        e.preventDefault();
        selectedSort = $(this).data("sort");
        filterProducts();
    });

    $(".dropdown-item[data-limit]").click(function (e) {
        e.preventDefault();
        selectedLimit = $(this).data("limit");
        filterProducts();
    });

    $('#priceFilterForm input[type="checkbox"]').change(function () {
        if ($(this).attr("id") === "price-all") {
            if ($(this).is(":checked")) {
                $('#priceFilterForm input[type="checkbox"]')
                    .not(this)
                    .prop("checked", false);
            }
        } else {
            if ($(this).is(":checked")) {
                $("#price-all").prop("checked", false);
            }
        }
        filterProducts();
    });
});
