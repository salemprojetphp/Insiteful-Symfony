const notifications = document.querySelector('.dropdown__wrapper');
const notificationsBtn = document.querySelector('.notification-btn');
const notificationsContainer = document.querySelector('.notification-container');

if(notifications && notificationsBtn) {
    notificationsBtn.addEventListener('click', (event) => {
        event.preventDefault();
        notifications.classList.remove('none');
        notifications.classList.toggle('hide');
    });
}

if(notificationsContainer) {
    notificationsContainer.addEventListener('click', (event) => {
        let notification = event.target.closest('.notification');
        if(notification){
            if(notification.classList.contains('notif-active')) {
                notification.classList.remove('notif-active');
            }
            fetch('/notifications/markAsSeen?id='+notification.id, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            window.location.href = "/blog/article?id=" + notification.dataset.postId;
        }
    });
}

const notifZero = document.querySelector('.notification-zero');
if(notifZero){
    notificationsContainer
}
// document.addEventListener('click', function(event){
//     if(!event.target.closest('.dropdown-wrapper') && !event.target.closest('.notification-btn'))
//             notifications.classList.remove('hide');
// });