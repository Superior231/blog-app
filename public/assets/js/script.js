// Navbar
try {
    const navbar = document.querySelector(".navbar");
    const navbar2 = document.querySelector(".navbar-detail");
    const classList = ["shadow-sm", "border-bottom", "border-secondary"];

    if (navbar || navbar2) {
        const handleScroll = () => {
            const action = window.pageYOffset > 0.1 ? 'add' : 'remove';
            if (navbar) navbar.classList[action](...classList);
            if (navbar2) navbar2.classList[action](...classList);
        };

        window.addEventListener("scroll", handleScroll);
    }
} catch (error) {
    console.log("Fitur navbar tidak ditemukan!");
}
// Navbar End


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


// Deskripsi See All
function viewDetails(id) {
    var detailsElement = document.getElementById("view-details-" + id);
    var detailsIconDown = document.getElementById("icon-down-" + id);
    var detailsIconUp = document.getElementById("icon-up-" + id);

    detailsElement.classList.toggle("active");

    if (detailsElement.classList.contains("active")) {
        detailsIconDown.style.display = "none";
        detailsIconUp.style.display = "block";
    } else {
        detailsIconDown.style.display = "block";
        detailsIconUp.style.display = "none";
    }
}
// Deskripsi See All End


// Copy Link
function copyLink(id) {
    const linkInput = document.getElementById("copy-link-" + id);
    const linkText = document.getElementById("copy-link-text-" + id);
    const linkBtn = document.getElementById("copy-link-btn-" + id);

    navigator.clipboard.writeText(linkInput.value).then(() => {
        linkText.innerHTML = '<i class="fa-solid fa-check text-dark"></i>';
        linkBtn.style.backgroundColor = "transparent";
        linkText.style.color = "#000";

        setTimeout(() => {
            linkText.innerHTML = '<i class="fa-solid fa-copy"></i>';
            linkBtn.style.backgroundColor = "#4564e5";
            linkText.style.color = "#fff";
        }, 5000);
    }).catch(error => {
        console.error('Fitur copy link tidak ditemukan!', error);
    });
}

function shareToFacebook(url) {
    const facebookShareLink = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
    window.open(facebookShareLink, '_blank');
}

function shareToX(url, title) {
    const XShareLink = `https://x.com/intent/post?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`;
    window.open(XShareLink, '_blank');
}

function shareToEmail(url, title) {
    const emailShareLink = `mailto:?subject=${encodeURIComponent(title)}&body=${encodeURIComponent(url)}`;
    window.location.href = emailShareLink;
}
// Copy Link End


// Code Block
const preElements = document.querySelectorAll("pre");

preElements.forEach((pre) => {
    let languageClass = "";
    let backgroundColor = "";

    if (pre.querySelector("code.language-php")) {
        languageClass = "PHP";
        backgroundColor = "#4e5c95";
        textColor = "#fff";
    } else if (pre.querySelector("code.language-html")) {
        languageClass = "HTML";
        backgroundColor = "#e34c26";
        textColor = "#fff";
    } else if (pre.querySelector("code.language-xml")) {
        languageClass = "XML";
        backgroundColor = "#e34c26";
        textColor = "#fff";
    } else if (pre.querySelector("code.language-css")) {
        languageClass = "CSS";
        backgroundColor = "#563c7d";
        textColor = "#fff";
    } else if (pre.querySelector("code.language-javascript")) {
        languageClass = "JavaScript";
        backgroundColor = "#ffb100";
        textColor = "#000";
    } else if (pre.querySelector("code.language-json")) {
        languageClass = "JSON";
        backgroundColor = "#ffb100";
        textColor = "#000";
    } else if (pre.querySelector("code.language-typescript")) {
        languageClass = "TypeScript";
        backgroundColor = "#084a86";
        textColor = "#fff";
    } else if (pre.querySelector("code.language-plaintext")) {
        languageClass = "Plain text";
        backgroundColor = "#757575";
        textColor = "#fff";
    } else if (pre.querySelector("code.language-c")) {
        languageClass = "C";
        backgroundColor = "#084a86";
        textColor = "#fff";
    } else if (pre.querySelector("code.language-cs")) {
        languageClass = "C#";
        backgroundColor = "#084a86";
        textColor = "#fff";
    } else if (pre.querySelector("code.language-cpp")) {
        languageClass = "C++";
        backgroundColor = "#084a86";
        textColor = "#fff";
    } else if (pre.querySelector("code.language-diff")) {
        languageClass = "Diff";
        backgroundColor = "#757575";
        textColor = "#fff";
    } else if (pre.querySelector("code.language-diff")) {
        languageClass = "Diff";
        backgroundColor = "#757575";
        textColor = "#fff";
    } else if (pre.querySelector("code.language-java")) {
        languageClass = "Java";
        backgroundColor = "#757575";
        textColor = "#fff";
    } else if (pre.querySelector("code.language-python")) {
        languageClass = "Python";
        backgroundColor = "#757575";
        textColor = "#fff";
    } else if (pre.querySelector("code.language-ruby")) {
        languageClass = "Ruby";
        backgroundColor = "#757575";
        textColor = "#fff";
    }


    if (languageClass) {
        // Create div with class code-block
        const div = document.createElement("div");
        div.classList.add("code-block", "position-relative");
        
        // Create label with class language-code
        const label = document.createElement("label");
        label.textContent = languageClass;
        label.classList.add("language-code", "fs-8");
        label.style.backgroundColor = backgroundColor;
        label.style.color = textColor;
        
        // Append label to div
        div.appendChild(label);
        
        // Insert div before pre
        pre.parentNode.insertBefore(div, pre);
        
        // Move pre inside div
        div.appendChild(pre);
    }
});
// Code Block End
