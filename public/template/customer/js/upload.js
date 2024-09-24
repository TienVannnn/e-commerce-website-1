// let uploadedImages = []; // Mảng chứa các ảnh đã upload

FilePond.setOptions({
    server: {
        process: {
            url: route("upload"),
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            onload: (response) => {
                const jsonResponse = JSON.parse(response);
                // console.log(jsonResponse); // Xem cấu trúc response
                if (jsonResponse.filename) {
                    let imagesContainer =
                        document.querySelector("#images-container");
                    let newInput = document.createElement("input");
                    newInput.type = "hidden";
                    newInput.name = "images[]";
                    newInput.value = jsonResponse.filename;
                    imagesContainer.appendChild(newInput);

                    // sự kiện khi reload trang sẽ xóa ảnh temp
                    // uploadedImages.push(jsonResponse.filename);

                    return jsonResponse.filename;
                } else {
                    console.error("Filename not found in response");
                }
            },
            onerror: (response) => console.error(response),
        },

        revert: async (uniqueFileId, load) => {
            try {
                const response = await fetch(route("revert"), {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({ filename: uniqueFileId }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            load();
                        } else {
                            console.error("Error:", data.error);
                        }
                    })
                    .catch((error) => console.error("Error:", error));

                // Xóa filename khỏi mảng images
                const imagesContainer =
                    document.querySelector("#images-container");
                const inputs = imagesContainer.querySelectorAll(
                    'input[name="images[]"]'
                );

                inputs.forEach((input) => {
                    if (input.value === uniqueFileId) {
                        imagesContainer.removeChild(input);
                    }
                });
            } catch (error) {
                console.error("Error deleting file:", error);
            }
        },
    },
});

FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginFileValidateSize
);

FilePond.create(document.querySelector('input[name="image[]"]'), {
    allowMultiple: true,
    maxFiles: 6,
    maxFileSize: "2MB",
    labelIdle: `Kéo thả hoặc nhấp để tải ảnh lên (Tối đa 6 ảnh, mỗi ảnh không quá 2MB)`,
});

// Thêm sự kiện beforeunload để xóa ảnh tạm nếu người dùng không submit
// window.addEventListener("beforeunload", (event) => {
//     if (uploadedImages.length > 0) {
//         fetch(route("clear.temp.images"), {
//             method: "POST",
//             headers: {
//                 "X-CSRF-TOKEN": document
//                     .querySelector('meta[name="csrf-token"]')
//                     .getAttribute("content"),
//                 "Content-Type": "application/json",
//             },
//             body: JSON.stringify({ images: uploadedImages }),
//         });
//     }
// });
