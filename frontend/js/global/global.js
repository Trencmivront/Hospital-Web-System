/* Set the width of the side navigation to 250px */
window.addEventListener('load', () => {
  document.getElementById("close_button").addEventListener('click', () => {
    document.getElementById("nav_container").classList.toggle('open');
  });
});