document.querySelectorAll(".star-rating i").forEach(function (star) {
    star.addEventListener("click", function () {
        let value = this.getAttribute("data-value");
        document.getElementById("rate").value = value;

        // Làm mới màu các sao
        document.querySelectorAll(".star-rating i").forEach(function (s) {
            s.classList.remove("fas"); // Sao rỗng
            s.classList.add("far");
        });

        // Tô màu những sao đã chọn
        for (let i = 0; i < value; i++) {
            document
                .querySelectorAll(".star-rating i")
                [i].classList.remove("far");
            document.querySelectorAll(".star-rating i")[i].classList.add("fas"); // Sao đầy
        }
    });
});
