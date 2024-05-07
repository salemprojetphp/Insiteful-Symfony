const addBtn = document.querySelector('#add-web-btn');
const URL = document.querySelector('#website_url');
const websiteForm = document.querySelector('.add-website-form');
const cancelBtn = document.querySelector('#cancel-website-button');
const confirmAddBtn = document.querySelector('#website_submit');

addBtn.addEventListener('click', () => {
    websiteForm.classList.toggle('hidden');
    URL.focus();
    document.querySelector('#bg').classList.toggle('blurry');
});

document.getElementById("copy-button").addEventListener("click", function() {
    var inputValue = document.getElementById("input-value");
    inputValue.select();
    document.execCommand("copy");

    const img = document.getElementById("copy-button").querySelector("img");
    img.src = "/images/copied.png";
});

cancelBtn.addEventListener('click', () => {
    websiteForm.classList.add('hidden');
    document.querySelector('#bg').classList.remove('blurry');
});

confirmAddBtn.addEventListener('click', (e) => {
    var url = URL.value;
    var urlRegex = /^(https?|ftp):\/\/[^\s/$.?#]+\.[a-zA-Z]{2,}$/;
    
    if (!urlRegex.test(url)) {
        alert('Please enter a valid URL.');
        e.preventDefault();
        return;
    }
    
    if (url === '') {
        e.preventDefault();
        alert('Please enter a URL');
    } 

    websiteForm.classList.toggle('hidden');
    document.querySelector('#bg').classList.toggle('blurry');
    URL.value = '';
});

