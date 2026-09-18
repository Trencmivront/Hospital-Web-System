window.addEventListener('load', ()=>{
    alert("UYARI: Bu website test amaçlıdır. Lütfen kişisel bilgilerinizi yazmayın.\n"+
        "WARNING: This is a test website. Please do not share your personal information.");
} )

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