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
    if(!session){
        window.location.href="/auth";
        return;
    }
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
