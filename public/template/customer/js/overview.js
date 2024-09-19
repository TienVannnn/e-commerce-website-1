// document.querySelectorAll(".overview-btn").forEach(function (element) {
//     element.addEventListener("click", function (e) {
//         document.querySelectorAll(".overview-btn").forEach(function (el) {
//             el.classList.remove("active");
//         });
//         this.classList.add("active");
//     });
// });

// $(document).ready(function () {
//     $(".overview-btn").click(function (e) {
//         e.prenventDefault();
//         $(".overview-btn").removeClass("active");
//         $(this).addClass("active");
//         // Điều hướng đến trang mới
//         window.location.href = $(this).attr("href");
//     });
// });

// $(document).ready(function () {
//     $(".overview-btn").click(function () {
//         // Xóa lớp "active" khỏi tất cả các liên kết
//         // $(".overview-btn").removeClass("active");
//         // Thêm lớp "active" cho liên kết được nhấp
//         $(this).addClass("active");
//     });
// });

// function activeTab(obj) {
//     // xóa class active tất cả các tab
//     $(".tab1 ul li").removeClass("active");
//     // Thêm class active vào tab đang click
//     $(obj).addClass("active");
//     // Lấy href của tab để show content tương ứng
//     var id = $(obj).find("a").attr("href");
//     // Ẩn hết nội dung các tab đang hiện thị
//     $(".tab").hide();
//     // Hiển thị nội dung của tab hiện tại
//     $(id).show();
// }
// // su kien click doi tab
// $(".tab2 li").click(function () {
//     activeTab(this);
//     return false;
// });
// // active tab dau tien trang web duoc chay
// activeTab($(".tab2 li:first-child"));
