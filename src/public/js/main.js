/* ** 
* */
function colorizeTexts(customClass) {
    let messages = document.querySelectorAll(customClass);

    messages.forEach(msg => msg.style.color = msg.dataset.usercolor);
}

function closeToast(event) {
    let toast = event.target.parentNode;

    toast.classList.add('hideToast');
}

function hideToast() {
    let toasts = document.querySelectorAll('.toast .close');

    toasts.forEach(btn => btn.addEventListener('click', closeToast));
}

colorizeTexts('.messages');
colorizeTexts('.user');
hideToast();
