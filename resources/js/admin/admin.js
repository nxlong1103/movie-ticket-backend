document.addEventListener("DOMContentLoaded", function () {
    let dropdowns = document.querySelectorAll(".dropdown-toggle-custom");

    dropdowns.forEach((dropdown) => {
        dropdown.addEventListener("click", function (e) {
            e.preventDefault();

            let parent = this.parentElement;
            let menu = parent.querySelector(".dropdown-menu-custom");

            // Đóng tất cả menu khác
            document.querySelectorAll(".dropdown-menu-custom").forEach((el) => {
                if (el !== menu) {
                    el.classList.remove("show");
                }
            });

            // Toggle menu hiện tại
            menu.classList.toggle("show");
        });
    });
});
