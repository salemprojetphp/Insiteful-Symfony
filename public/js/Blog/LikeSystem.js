const likeBtns = document.querySelectorAll(".like-btn");
const session = document.querySelector('body').classList.contains('true');

    likeBtns.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            if(!session){
                window.location.href = "/auth"; 
            } else {
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
                    newSrc = '../public/images/like-active.svg';
                    nbLikes.textContent= parseInt(nbLikes.textContent) + 1;
                    fetch(`/blog/like?id=${img.dataset.postId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                } else {
                    newSrc = '../public/images/like.svg';
                    nbLikes.textContent= parseInt(nbLikes.textContent) - 1;
                    fetch(`/blog/dislike?id=${img.dataset.postId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    })
                }

                img.setAttribute('src', newSrc);
            }
        });
    });


