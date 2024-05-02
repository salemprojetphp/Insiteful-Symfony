const sendBtn= document.getElementById('send-button');
const emailInput=document.getElementById('email-input');


sendBtn.addEventListener('click', function(event) {
    let invalid=false
    function isValidEmail(mail) {
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailPattern.test(mail);
    }
    if (!isValidEmail(emailInput.value.trim())){
        invalid=true;
    }
    if(invalid){
        event.preventDefault();
    }
});
