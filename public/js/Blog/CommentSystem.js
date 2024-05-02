const commentBtn = document.querySelector(".comment-btn");
const form = document.querySelector("#comment-form");
const commentsContainer = document.querySelector('.comments');
const username = document.querySelector(".full-article").id;
const nbComments = document.querySelector('.nb-comments');
let deleteCommentBtns= document.querySelectorAll('.delete-comment-btn');


commentBtn.addEventListener('click', function(e) {
    e.preventDefault();
    const comment = form.querySelector('textarea[name="comment"]').value;
    if (!comment) {
        return;
    }
    if(!session){
        window.location.href="/auth";
        return;
    }
    fetch(form.action, {
        method: 'POST',
        body: new FormData(form)
    })
    .then(response => {
        form.reset();
        typeComment.style.height = originalHeightTypeComment + 'px';
        const author = username;
        const currentDate = new Date();
        addComment(author, comment, "Just Now");
    })
    .catch(error => {
        console.error('Error submitting comment:', error);
    });
});

function assignDeleteEventListeners() {
    deleteCommentBtns = document.querySelectorAll('.delete-comment-btn');
    deleteCommentBtns.forEach(btn => {
        btn.addEventListener('click', function(event) {
            event.preventDefault();
            const comment_id = btn.id;
            const comment = btn.closest('.comment');
            fetch(`/deleteComment?id=${comment_id}`, {
                method: 'GET'
            });
            comment.remove();
            nbComments.innerHTML = parseInt(nbComments.innerHTML) - 1;
        });
    });
}
function assignEditCommentEventListener() {
    document.querySelectorAll('.edit-comment-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const comment = btn.closest('.comment');
            const textarea = comment.querySelector('.comment-content');
            if (btn.querySelector('img').src.includes('edit.png')) {
                btn.querySelector('img').src = '../public/images/save.png';
                textarea.readOnly = false; 
                textarea.focus(); 
            } else {
                const comment_id = btn.id;
                fetch(`/editComment?id=${comment_id}&content=${textarea.value}`, {
                    method: 'GET'
                });
                textarea.readOnly = true; 
                btn.querySelector('img').src = '../public/images/edit.png';
            }
        });
    });
}
function addComment(author, content, time) {
    fetch('/commentId',{
        header : 'Content-Type: application/json',
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.text();
    })
    .then(max_id => {
        const commentHTML = `
            <div class="comment" id='${max_id}'>
                <div class="comment-info flex">
                    <div class="user">
                        <img src="../public/images/user.png" width="32" height="32" alt="author">
                        <span class="ml8 mr32">${author}</span>
                    </div>
                    <span class="caption gray">${time}</span>
                    <div class='comment-btns'>
                        <button class='edit-comment-btn' id='${max_id}'>
                            <img src='../public/images/edit.png' alt='edit'>
                        </button>
                        <button class='delete-comment-btn' id='${max_id}'>
                            <img src='../public/images/delete.png' alt='delete'>
                        </button>
                    </div>
                </div>
                <textarea class='comment-content' readonly>${content}</textarea>
            </div>
        `;
        commentsContainer.innerHTML = commentHTML + commentsContainer.innerHTML;
        nbComments.innerHTML = parseInt(nbComments.innerHTML) + 1;
        assignDeleteEventListeners();
        assignEditCommentEventListener();
    })
    .catch(error => console.error('Error fetching max comment ID:', error));
}

assignEditCommentEventListener();
assignDeleteEventListeners();
