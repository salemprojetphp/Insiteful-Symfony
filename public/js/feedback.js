
const contentInput = document.getElementById('feedback');
const submitButton = document.getElementById('add-btn');
//can't submit if  content is empty
submitButton.addEventListener('click', function(event) {
    let isEmpty = false;

    if (contentInput.value.trim() === '') {
        isEmpty = true;
    }
    if(isEmpty){
        event.preventDefault();
    }
});