document.addEventListener("DOMContentLoaded", function () {
    const carouselInner = document.querySelector(
        "#carouselMovies .carousel-inner"
    );
    const toggleButton = document.getElementById("view-more"); // Nút Xem thêm/Thu lại
    let allMovies = window.moviesData || []; // Lấy dữ liệu từ Laravel Blade
    let maxMoviesPerSlide = 4; // Số phim hiển thị trên mỗi slide
    let expanded = false; // Trạng thái mở rộng (false = 4 phim, true = tất cả phim)

    function renderMovies() {
        carouselInner.innerHTML = ""; // Xóa nội dung cũ

        let chunks = chunkArray(allMovies, maxMoviesPerSlide);
        chunks.forEach((chunk, index) => {
            let isActive = index === 0 ? "active" : "";
            let slideContent = `
                <div class="carousel-item ${isActive}">
                    <div class="row row-cols-1 row-cols-md-4 g-4">
            `;

            chunk.forEach((movie) => {
                slideContent += `
                    <div class="col movie-item">
                        <div class="card movie-card">
                            <div class="movie-image-container">
                                <img src="/images/${
                                    movie.image
                                }" class="card-img-top" alt="${movie.title}">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">${movie.title}</h5>
                                <p class="card-text">${movie.description.substring(
                                    0,
                                    100
                                )}...</p>
                                <div class="d-flex justify-content-between mt-auto gap-2">
                                    <a href="${
                                        movie.trailer_url
                                    }" target="_blank" class="btn btn-trailer">🎬 Xem Trailer</a>
                                    <a href="/movies/${
                                        movie.id
                                    }" class="btn btn-ticket">ĐẶT VÉ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            slideContent += `</div></div>`;
            carouselInner.innerHTML += slideContent;
        });

        toggleButton.textContent = expanded ? "Thu lại" : "Xem thêm";
    }

    function chunkArray(array, chunkSize) {
        let results = [];
        for (let i = 0; i < array.length; i += chunkSize) {
            results.push(array.slice(i, i + chunkSize));
        }
        return results;
    }

    toggleButton.addEventListener("click", function () {
        expanded = !expanded;
        maxMoviesPerSlide = expanded ? allMovies.length : 4; // Nếu mở rộng thì hiển thị tất cả phim
        renderMovies();
    });

    renderMovies();
});
