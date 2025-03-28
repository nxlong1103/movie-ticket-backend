document.addEventListener("DOMContentLoaded", function () {
    let selectedSeats = [];

    document.querySelectorAll(".seat-label").forEach((seat) => {
        seat.addEventListener("click", function () {
            if (this.classList.contains("booked")) return; // Không chọn ghế đã đặt

            this.classList.toggle("selected");
            let seatNumber = this.getAttribute("data-seat");

            if (this.classList.contains("selected")) {
                selectedSeats.push(seatNumber);
            } else {
                selectedSeats = selectedSeats.filter((s) => s !== seatNumber);
            }

            document.getElementById("selectedSeats").value =
                selectedSeats.join(",");
        });
    });
});

function toggleSeats() {
    let seatType = document.getElementById("seatType").value;
    document.getElementById("standardSeats").style.display =
        seatType === "standard" ? "block" : "none";
    document.getElementById("vipSeats").style.display =
        seatType === "VIP" ? "block" : "none";
}
