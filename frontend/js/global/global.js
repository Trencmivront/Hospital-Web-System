/* Toggle side navigation and animate the close/menu button */
window.addEventListener('load', () => {
  const closeBtn = document.getElementById("close_button");
  const navContainer = document.getElementById("nav_container");

  if (closeBtn && navContainer) {
    closeBtn.addEventListener('click', () => {
      navContainer.classList.toggle('open');

      // Optional: Toggle icon between hamburger and close
      if (navContainer.classList.contains('open')) {
        closeBtn.innerHTML = "&times;"; // Multiplier sign (X)
      } else {
        closeBtn.innerHTML = "&#9776;"; // Hamburger menu icon
      }
    });
  }

  // Auto-sliding carousel functionality
  const carousel = document.querySelector('.carousel__viewport');
  if (carousel) {
    let currentSlide = 0;
    const slides = carousel.querySelectorAll('.carousel__slide');
    const totalSlides = slides.length;

    // Function to go to next slide
    function nextSlide() {
      currentSlide = (currentSlide + 1) % totalSlides;
      const slideWidth = carousel.clientWidth;
      carousel.scrollTo({
        left: currentSlide * slideWidth,
        behavior: 'smooth'
      });
    }

    // Auto slide every 4 seconds
    setInterval(nextSlide, 4000);

    // Pause auto-sliding on hover
    carousel.addEventListener('mouseenter', () => {
      // Could add pause functionality here if needed
    });

    carousel.addEventListener('mouseleave', () => {
      // Could resume here if needed
    });
  }
});
   