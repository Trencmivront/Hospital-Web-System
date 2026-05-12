let currentSlide = 0;
const totalSlides = 3;
const slider = document.querySelector('.slider');
let autoPlay;

function changeSlide(direction) {
    currentSlide = (currentSlide + direction + totalSlides) % totalSlides;
    slider.style.animation = 'none';
    slider.style.transform = `translateX(-${currentSlide * 33.33}%)`;
    
    // to restart the automatic movement from the current image
    clearInterval(autoPlay);
    startAutoPlay();
}

function startAutoPlay() {
    autoPlay = setInterval(() => {
        currentSlide = (currentSlide + 1) % totalSlides;
        slider.style.animation = 'none';
        slider.style.transform = `translateX(-${currentSlide * 33.33}%)`;
    }, 4000); // the photo will change every 4 seconds
}

// to start the automatic change and sliding when the page loads
startAutoPlay();