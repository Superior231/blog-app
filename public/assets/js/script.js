const navbar = document.querySelector(".navbar");

window.addEventListener("scroll", () => {
    if(window.pageYOffset > 0.1) {
        navbar.classList.add("shadow-sm", "border-bottom", "border-secondary");
    }
    else {
        navbar.classList.remove("shadow-sm", "border-bottom", "border-secondary");
    }
});


// Back to Top
const iconBackToTop = document.querySelector(".icon-back-to-top");

try {
    if (iconBackToTop) {
        window.addEventListener("scroll", () => {
            if(window.pageYOffset > 100) {
                iconBackToTop.classList.add("active");
            }
            else {
                iconBackToTop.classList.remove("active");
            }
        });
    }
} catch (error) {
    console.log('Fitur back to top tidak ditemukan!');
}
// Back to Top End