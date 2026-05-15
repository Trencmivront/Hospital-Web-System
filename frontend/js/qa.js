// Q&A Toggle Functionality
document.querySelectorAll(".qa-question").forEach(function(btn) {
    btn.addEventListener("click", function() {
        const qaItem = this.closest(".qa-item");
        const isActive = qaItem.classList.contains("active");
        
        // Close other items if needed
        document.querySelectorAll(".qa-item.active").forEach(item => {
            if (item !== qaItem) {
                item.classList.remove("active");
            }
        });
        
        // Toggle current item
        if (isActive) {
            qaItem.classList.remove("active");
        } else {
            qaItem.classList.add("active");
        }
    });
});

// Tab Filtering Functionality
document.querySelectorAll(".qa-tab").forEach(function(tab) {
    tab.addEventListener("click", function() {
        const category = this.getAttribute("data-category");
        
        // Update active tab
        document.querySelectorAll(".qa-tab").forEach(t => t.classList.remove("active"));
        this.classList.add("active");
        
        // Filter Q&A items
        document.querySelectorAll(".qa-item").forEach(item => {
            if (category === "general" || item.getAttribute("data-category") === category) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
        
        // Close all answers when filtering
        document.querySelectorAll(".qa-item.active").forEach(item => {
            item.classList.remove("active");
        });
    });
});
