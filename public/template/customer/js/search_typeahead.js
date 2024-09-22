$(document).ready(function () {
    var products = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("name"),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "/search?query=%QUERY%",
            wildcard: "%QUERY%",
        },
    });

    function formatPrice(price) {
        return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "đ"; // Thêm dấu phân cách ngàn
    }

    $(".search-box").typeahead(
        {
            hint: true,
            highlight: true,
            minLength: 1,
        },
        {
            name: "products",
            display: "name",
            source: products,
            templates: {
                // Template gợi ý sản phẩm
                suggestion: function (data) {
                    return `
                    <div class="product-suggestion d-flex align-items-center">
                        <a href ="/product/${
                            data.slug
                        }"><img src="/uploads/products/${data.image}" alt="${
                        data.name
                    }" style="width:50px; height:50px; margin-right: 10px;"></a>
                        <div class="flex-col text-left">
                        <a href ="/product/${data.slug}" class="product-name">${
                        data.name
                    }</a>
                             <p class="product-price">${formatPrice(
                                 data.price
                             )}</p>
                        </div>
                    </div>`;
                },
                empty: [
                    '<div class="empty-message">No products found</div>',
                ].join("\n"),
            },
        }
    );
});
