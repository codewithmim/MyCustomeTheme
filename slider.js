document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.slider .slide');

    if (slides.length === 0) return;

    let current = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.display = i === index ? 'block' : 'none';
        });
    }

    function nextSlide() {
        current = (current + 1) % slides.length;
        showSlide(current);
    }

    showSlide(current);
    setInterval(nextSlide, 5000);
});
