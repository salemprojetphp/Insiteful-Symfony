const openMenu = document.querySelector('.user-session-info');
const menu = document.querySelector('.dropdown');
const contactBtn = document.querySelector('.contact-btn');
const cancelContactBtn = document.querySelector('.cancel-button');
const contactForm = document.querySelector('.container');
const background = document.querySelector('main');
const feedbackBtn = document.querySelector('.feedback-btn');
const feedbackForm = document.querySelector('.feedback-container');
const cancelFeedbackBtn = document.querySelector('.cancel-feedback-button');

if(openMenu && menu) {
    openMenu.addEventListener('click', (event) => {
        event.stopPropagation(); 
        menu.style.display = menu.style.display == 'flex' ? 'none' : 'flex';
    });
}

document.addEventListener('click', (event) => {
    const targetElement = event.target;
    if (!targetElement.closest('.user-session-info') && menu.style.display === 'flex') {
        menu.style.display = 'none';
    } 
});






if(cancelContactBtn && contactBtn && contactForm) {
    contactBtn.addEventListener('click', function(event) {
        const contactFormDisplay = window.getComputedStyle(contactForm).getPropertyValue('display');
        event.preventDefault();
        contactForm.style.display = (contactFormDisplay === 'none') ? 'block' : 'none';
        background.classList.toggle('blur');
    });

    cancelContactBtn.addEventListener('click', function(event) {
        event.preventDefault();
        contactForm.style.display = 'none';
        background.classList.remove('blur');
    });
    
    document.addEventListener('click', (event) => {
    const targetElement = event.target;
    console.log(!targetElement.closest('.contact-container'));
    if (!targetElement.closest('.contact-container') && targetElement !== contactBtn && contactForm.style.display === 'block') {
        contactForm.style.display = 'none';
        background.classList.remove('blur');
        
    }
});
}


if(contactBtn && contactForm) {
    contactBtn.addEventListener('click', function(event) {
        const contactFormDisplay = window.getComputedStyle(contactForm).getPropertyValue('display');})
}
if(cancelFeedbackBtn && feedbackBtn && feedbackForm) {
    feedbackBtn.addEventListener('click', function(event) {
        const feedbackFormDisplay = window.getComputedStyle(feedbackForm).getPropertyValue('display');
        event.preventDefault();
        feedbackForm.style.display = (feedbackFormDisplay === 'none') ? 'flex' : 'none';
        background.classList.toggle('blur');
    });

    cancelFeedbackBtn.addEventListener('click', function(event) {
        event.preventDefault();
        feedbackForm.style.display = 'none';
        background.classList.remove('blur');
    });
    document.addEventListener('click', (event) => {
    const targetElement = event.target;
    if (!targetElement.closest('.feedback-container') && targetElement !== feedbackBtn && feedbackForm.style.display === 'flex') {
        feedbackForm.style.display = 'none';
        background.classList.remove('blur');
    }
});
}

const optionMenu = document.querySelector(".selection-menu"),
    userInfo = optionMenu.querySelector(".user-session-info"),
    options = optionMenu.querySelectorAll(".option"),
    usernameText = optionMenu.querySelector(".username-text");

userInfo.addEventListener("click", () => optionMenu.classList.toggle("active"));

options.forEach(option =>{
    option.addEventListener("click", ()=>{
        optionMenu.classList.remove("active");
    });
});

