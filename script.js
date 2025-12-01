// ===== Background Image Slideshow =====
const bgImages = ['l.jpg', 'm.jpg', 'n.jpg', 'o.jpg']; // add your images here
let bgIndex = 0;

function changeBackground() {
    document.body.style.backgroundImage = `url('${bgImages[bgIndex]}')`;
    bgIndex = (bgIndex + 1) % bgImages.length;
}

// Change background every 3 seconds
setInterval(changeBackground, 3000);
changeBackground(); // set initial background

// ===== Price Calculator =====
document.getElementById("calcBtn").addEventListener("click", function () {
    let services = document.querySelectorAll(".service:checked");
    let total = 0;
    let selectedServices = [];

    services.forEach(item => {
        total += parseInt(item.value);
        selectedServices.push(item.parentElement.textContent.trim());
    });

    document.getElementById("totalPrice").textContent =
        "Total Price: Rs. " + total;

    // Save total price in hidden input for PHP
    document.getElementById("PriceInput").value = total;

    // Save selected services for optional confirmation
    window.selectedServices = selectedServices;
    window.totalPrice = total;
});

// ===== Booking Form =====
document.getElementById("bookingForm").addEventListener("submit", function (e) {
    e.preventDefault(); // prevent default form submission to show confirmation first
    let name = document.getElementById("name").value;
    let date = document.getElementById("date").value;
    let time = document.getElementById("time").value;

    document.getElementById("confirmation").textContent =
        "💗 Appointment booked for " + name + " on " + date + " at " + time + " 💗";

    // Submit form after short delay (optional)
    setTimeout(() => this.submit(), 2000);
});
