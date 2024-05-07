const contentInput = document.getElementById('feedback');
const submitButton = document.getElementById('add-btn');
const feedbackWindow = document.querySelector('.feedback-container');

submitButton.addEventListener('click', function(event) {
    event.preventDefault();

    if (contentInput.value.trim() === '') {
        console.log('Feedback content is empty');
        return;
    }

    const feedback = contentInput.value;

    fetch('/feedbacks/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ feedback }),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to add feedback');
        }
        return response.json();
    })
    .then(data => {
        console.log('Feedback added:', data);
        // Handle success
    })
    .catch(error => {
        console.error('Error:', error);
        // Handle error
    });
    feedbackWindow.classList.add('hidden');
});
