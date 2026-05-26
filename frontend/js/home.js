/* JavaScript Function to link thumbnails to the slider */
function currentSlide(n) {
    let slides = document.getElementsByClassName("slide");
    
    // Hide all slides first
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    
    // Show the requested slide
    if (slides[n-1]) {
        slides[n-1].style.display = "block";
        
        // Scroll smoothly to the top of the hero section
        document.querySelector('.hero-section-container').scrollIntoView({ 
            behavior: 'smooth' 
        });
    }
}