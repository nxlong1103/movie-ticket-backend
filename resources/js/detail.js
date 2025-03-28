document
    .querySelector(".booking-form")
    .addEventListener("submit", function (event) {
        // Lấy giá trị từ các select
        const theaterSelect = document.querySelector('[name="theater_id"]');
        const dateSelect = document.querySelector('[name="date"]');
        const showtimeSelect = document.querySelector('[name="showtime_id"]');
        const errorMessage = document.getElementById("error-message");

        // In ra console để kiểm tra
        console.log("theaterSelect.value: ", theaterSelect.value);
        console.log("dateSelect.value: ", dateSelect.value);
        console.log("showtimeSelect.value: ", showtimeSelect.value);

        // Kiểm tra xem tất cả các trường có được chọn hay không
        if (
            !theaterSelect.value ||
            !dateSelect.value ||
            !showtimeSelect.value
        ) {
            // Nếu có trường chưa chọn, dừng form submit và hiển thị thông báo lỗi
            event.preventDefault();

            // Hiển thị thông báo lỗi
            errorMessage.classList.remove("d-none");
            errorMessage.classList.add("d-block");
        } else {
            // Ẩn thông báo lỗi khi mọi thứ hợp lệ
            errorMessage.classList.remove("d-block");
            errorMessage.classList.add("d-none");
        }
    });
