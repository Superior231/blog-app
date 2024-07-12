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



// Image Preview
const previews = [
    { input: document.getElementById('edit-avatar-input'), preview: document.getElementById('edit-avatar') }
];

previews.forEach(item => {
    try {
        item.input.onchange = (e) => {
            if (item.input.files && item.input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    item.preview.src = e.target.result;
                };
                reader.readAsDataURL(item.input.files[0]);
            }
        };
    } catch (error) {
        console.log('Fitur preview gambar tidak ditemukan!');
    }
});
// Image Preview End