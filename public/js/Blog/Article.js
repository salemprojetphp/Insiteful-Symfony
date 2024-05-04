const typeComment = document.querySelector('textarea[name="comment"]');
const originalHeightTypeComment = 48;
const commentContent = document.querySelectorAll('.comment-content');

function resizeCommentTextarea() {
    typeComment.style.height = 'auto';
    typeComment.style.height = typeComment.scrollHeight -11 + 'px';
}
resizeCommentTextarea();

typeComment.addEventListener('keydown', function(event) {
    if (event.keyCode === 13 && !event.shiftKey) { 
        event.preventDefault();
        commentBtn.click(); 
    }
});

typeComment.addEventListener('input', function(){
    // if(!session){
    //     window.location.href="/auth";
    //     return;
    // }
    resizeCommentTextarea();
    if (this.value.length > 400) {
        this.value = this.value.slice(0, 400);
    }
});

function AdjustCommentSize(){
    commentContent.forEach(comment => {
        comment.style.height = comment.scrollHeight + 'px';
    });
}
AdjustCommentSize();

if (window.location.href.endsWith("/comments")) {
    const commentSection = document.getElementById("comments");
    if (commentSection) {
        commentSection.scrollIntoView({ behavior: "smooth", block: "start", inline: "nearest" });
    }
}

function reverseComments() {
    const comments = document.querySelectorAll('.comment');
    const commentsArray = Array.from(comments);
    commentsArray.reverse();
    const commentContainer = document.querySelector('.comments');
    commentContainer.innerHTML = '';
    commentsArray.forEach(comment => {
        commentContainer.appendChild(comment);
    });
}
reverseComments();