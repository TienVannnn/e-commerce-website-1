$(document).ready(function () {
    $(".tag-select").select2({
        tags: true,
        tokenSeparators: [",", " "],
    });

    $(".category-select").select2({
        placeholder: "Select a state",
        allowClear: true,
    });
});

document
    .getElementById("image_detail")
    .addEventListener("change", function (event) {
        const imagePreviewContainer = document.getElementById("image_preview");
        imagePreviewContainer.innerHTML = ""; // Xóa các ảnh cũ khi chọn lại

        const files = event.target.files;
        if (files) {
            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                // Tạo thẻ div chứa ảnh và nút xóa
                const imageDiv = document.createElement("div");
                imageDiv.classList.add("image-item");
                imageDiv.style.position = "relative";
                imageDiv.style.display = "inline-block";
                imageDiv.style.marginRight = "10px";

                // Tạo thẻ img để hiển thị ảnh
                const img = document.createElement("img");
                img.src = URL.createObjectURL(file);
                img.style.width = "50px";
                img.style.height = "50px";
                img.style.objectFit = "cover";
                img.style.border = "1px solid #ddd";
                img.style.borderRadius = "5px";

                // Tạo nút xóa
                const removeBtn = document.createElement("button");
                removeBtn.innerHTML = "X";
                removeBtn.style.position = "absolute";
                removeBtn.style.top = "5px";
                removeBtn.style.right = "5px";
                removeBtn.style.backgroundColor = "#ff0000";
                removeBtn.style.color = "#fff";
                removeBtn.style.border = "none";
                removeBtn.style.borderRadius = "50%";
                removeBtn.style.cursor = "pointer";

                // Xử lý sự kiện xóa ảnh
                removeBtn.addEventListener("click", function () {
                    imageDiv.remove();
                });

                // Thêm img và nút xóa vào div
                imageDiv.appendChild(img);
                imageDiv.appendChild(removeBtn);

                // Thêm div vào container
                imagePreviewContainer.appendChild(imageDiv);
            }
        }
    });
