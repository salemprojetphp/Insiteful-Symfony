const sendBtn= document.getElementById('send-button');
const emailInput=document.getElementById('email-input');
const objectInput=document.getElementById('object-input');
const messageInput=document.getElementById('message-input');


sendBtn.addEventListener('click', function(event) {
    event.preventDefault();
    let invalid=false
    function isValidEmail(mail) {
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailPattern.test(mail);
    }
    if (!isValidEmail(emailInput.value.trim())){
        invalid=true;
    }
    if(!invalid){
        fetch('/contact', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email: emailInput.value.trim(),
                object: objectInput.value.trim(),
                message: messageInput.value.trim(),
            })

        })
    }
});
