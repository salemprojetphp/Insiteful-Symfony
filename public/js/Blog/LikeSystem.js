const likeBtns = document.querySelectorAll(".like-btn");
// const session = document.querySelector('body').classList.contains('true');

    likeBtns.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            // if(!session){
                // } else {
                    let img, nbLikes, newSrc;
                    e.preventDefault();
                    
                    if(e.target.tagName == 'BUTTON') {
                        img = e.target.querySelector('img');
                        nbLikes = e.target.querySelector('p');
                    } else {
                        img = e.target.parentElement.querySelector('img');
                        nbLikes = e.target.parentElement.querySelector('p');
                    }
                    
                    const currentSrc = img.getAttribute('src');
                    if (currentSrc.includes('like.svg')) {
                        newSrc = '/images/like-active.svg';
                        nbLikes.textContent= parseInt(nbLikes.textContent) + 1;
                    fetch(`/post/like/${btn.dataset.postId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                } else {
                    newSrc = '/images/like.svg';
                    nbLikes.textContent= parseInt(nbLikes.textContent) - 1;
                    fetch(`/post/unlike/${btn.dataset.postId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                }

                img.setAttribute('src', newSrc);
            // }
        });
    });


