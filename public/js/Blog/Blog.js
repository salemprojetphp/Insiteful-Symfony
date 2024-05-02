//selection of filter buttons
const filterBtns = document.querySelectorAll(".filter-btn");
    let activeFilterBtns = document.querySelector(".selected");
    filterBtns.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            activeFilterBtns.classList.remove('selected');
            e.target.classList.add('selected');
            activeFilterBtns = e.target;
        });
    });

//removing the refresh from the articles && truncating the description
const posts = document.querySelectorAll('.blog-article');

    // Truncate text to a specified length without cutting words in half and only taking the three first lines
    function truncateText(text, limit) {
        let lastSpaceIndex = text.lastIndexOf(' ', limit);
        if (lastSpaceIndex === -1) {
            return text;
        }
        let truncatedText;
        if(text.length < 200){
            truncatedText=text;
        } else {
            truncatedText = text.substring(0, lastSpaceIndex);
        }
        let lines = truncatedText.split('\n');
        if (lines.length > 3) {
            lines=lines.slice(0,3);
            lines = lines.join('<br>');
            return lines+' ...';
        } else {
            return lines.join('<br>') + ' ...';
        }
    }
    

    // Truncate text in each post
    posts.forEach(function(post) {
        const description = post.querySelector('.blog-description');
        const originalText = description.textContent;
        description.innerHTML = truncateText(originalText,200);

        post.addEventListener('click', function(e,index) {
            e.preventDefault();
            e.stopPropagation();
            if(!e.target.closest('.blog-article-content-info')){
                window.location.href = `/blog/article?id=${post.id}`;
            }
        });
    });

// dropdown menu animation and event listener
const dropdownButtons = document.querySelectorAll('.more-btn');
const dropdownMenus = document.querySelectorAll('.dropdown-menu');

    // Attach click event listener to each dropdown button
    dropdownButtons.forEach(function(button, index) {
        button.addEventListener('click', function(event) {
            const menu = dropdownMenus[index];
            console.log(index);
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';

            dropdownMenus.forEach(function(otherMenu, otherIndex) {
                if (index !== otherIndex) {
                    otherMenu.style.display = 'none';
                }
            });
        });
    });

    // Close dropdown menus when clicking outside of them
    document.addEventListener('click', function(event) {
        dropdownMenus.forEach(function(menu) {
            if (!menu.contains(event.target)) {
                menu.style.display = 'none';
            }
        });
    });

    // redirecting to the deletePost/editPost page
    dropdownMenus.forEach(function(menu) {
        menu.addEventListener('click', function(event) {
            if (event.target.classList.contains('delete-btn')) {
                const postId = event.target.dataset.postId;
                if (confirm('Are you sure you want to delete this post?')) {
                    window.location.href = `/blog/deletePost?id=${postId}`;
                }
            } else if (event.target.classList.contains('edit-btn')) {
                const postId = event.target.dataset.postId;
                window.location.href = `/editPost?id=${postId}`;
            }
        });
    });


//when clicking comment redirecting to article page comment section 
const commentBtns = document.querySelectorAll('.comment-btn');

    commentBtns.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = `/blog/article?id=${btn.querySelector('img').dataset.postId}&comment='true'`;
        });
    });
