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

  // Theme Switching Logic
  const initTheme = () => {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    
    // Inject Theme Toggle UI
    // Look for various possible injection points
    const injectionPoints = [
      '.header-actions',
      '.top-bar-user-name',
      '.top-actions',
      'nav#nav_container',
      '.profile-top-bar .top-bar-content'
    ];
    
    let target = null;
    for (const selector of injectionPoints) {
      target = document.querySelector(selector);
      if (target) break;
    }
     
    const toggleContainer = document.createElement('div');
    toggleContainer.className = 'theme-toggle-container flex-center-content';
    toggleContainer.innerHTML = `
      <label>
        <input type="radio" name="theme" value="light" ${savedTheme === 'light' ? 'checked' : ''}> Light
      </label>
      <label>
        <input type="radio" name="theme" value="dark" ${savedTheme === 'dark' ? 'checked' : ''}> Dark
      </label>
    `;

    if (target) {
      if (target.tagName === 'NAV') {
        target.appendChild(toggleContainer);
      } else {
        target.prepend(toggleContainer);
      }
    } else {
      // Fallback: Fixed position if no header/nav found
      toggleContainer.classList.add('fallback');
      document.body.appendChild(toggleContainer);
    }
    
    toggleContainer.querySelectorAll('input[name="theme"]').forEach(radio => {
      radio.addEventListener('change', (e) => {
        const theme = e.target.value;
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
      });
    });
  };
  // loading map after page style is loaded
  const googleMap = document.getElementById("googleMap");
  if(googleMap){
    googleMap.setAttribute("src",
    "https://maps.google.com/maps?q=Pa%C5%9Fakonak%20Mah.%20Sa%C4%9Fl%C4%B1k%20Cad.%20No:4%20Band%C4%B1rma&t=&z=13&ie=UTF8&iwloc=&output=embed"
  );
  }
  

  initTheme();
});

   