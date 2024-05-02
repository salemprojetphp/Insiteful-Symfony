const titleInput = document.querySelector('#post_title');
const contentInput = document.querySelector('#post_content');
const submitButton = document.getElementById('add-btn');    

//can't submit if title or content is empty
// submitButton.addEventListener('click', function(event) {
//     let isEmpty = false;
//     if (titleInput.value.trim() === '') {
//         titleInput.classList.add('bg-red');
//         isEmpty = true;
//     }
//     if (contentInput.value.trim() === '') {
//         contentInput.classList.add('bg-red');
//         isEmpty = true;
//     }
//     if(isEmpty){
//         event.preventDefault();
//     }
// });

// removing alert when user starts typing
// [titleInput,contentInput].forEach(element => {  
//     element.addEventListener('input', function() {
//         if (this.value.trim() !== '') {
//             this.classList.remove('bg-red');
//         }
//     });
// });

// image preview +verify if image is valid
const imageInput = document.querySelector('input[name="post[image]"]');
const firstColorInput = document.querySelector('input[name="post[bgColor1]"]');
const secondColorInput = document.querySelector('input[name="post[bgColor2]"]');
const imagePreview = document.querySelector('.image-preview');
const imagePreviewimg = document.querySelector('.image-preview-image');
const deleteImageButton = document.getElementById('no-img-btn');

function isImage(file) {
    const acceptedImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/tiff', 'image/webp'];
    return file && acceptedImageTypes.includes(file.type);
}

imageInput.addEventListener('input', function(event) {
    const file = imageInput.files[0];
    const reader = new FileReader();

    if (file && !isImage(file)) {
        event.preventDefault(); 
        window.alert('Invalid image file');
        imageInput.value = null; 
        imagePreviewimg.src =''; 
        return;
    } else if (!file) {
        imagePreviewimg.src = '/images/hello.svg';
        return;
    }

    reader.onload = function() {
        imagePreviewimg.src = reader.result;
    }

    if (file) {
        reader.readAsDataURL(file);
    }
});

// delete imageinput and preview
deleteImageButton.addEventListener('click', function(event) {
    event.preventDefault();
    imageInput.value = null;
    imagePreviewimg.src = '/images/hello.svg';
});

// color preview
function toHex(color) {
    if (color.startsWith('#')) {
        return color;
    }
    if (color.startsWith('rgb')) {
        const rgbValues = color.match(/\d+/g); 
        const hexValues = rgbValues.map(value => {
            const hex = parseInt(value).toString(16); 
            return hex.length === 1 ? '0' + hex : hex; 
        });
        return `#${hexValues.join('')}`;
    }
    return color;
}

[firstColorInput,secondColorInput].forEach(
    element => element.addEventListener('input', function() {
        console.log('input');
        let bgColor1 = toHex(firstColorInput.value);
        let bgColor2 = toHex(secondColorInput.value);
        imagePreview.style.background = `linear-gradient(96.55deg, ${bgColor1} -25.2%, ${bgColor2} 55.15%)`;
    })
);
    
