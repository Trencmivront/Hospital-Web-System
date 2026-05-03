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
});