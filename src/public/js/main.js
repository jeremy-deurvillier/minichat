/* ** Colorize le texte dans une classe CSS, passée en paramètre.
* 
* @param String customClass Un sélecteur CSS.
* */
function colorizeTexts(customClass) {
    let messages = document.querySelectorAll(customClass);

    messages.forEach(msg => msg.style.color = msg.dataset.usercolor);
}

/* ** Ajout la classe hideToast aux toasts de notification.
* Permet de masquer un toast de notification.
*
* @param Event event Un événement JS.
* */
function closeToast(event) {
    let toast = event.target.parentNode;

    toast.classList.add('hideToast');
}

/* ** Ajoute un événement 'click' aux boutons .close des toasts.
* */
function hideToast() {
    let toasts = document.querySelectorAll('.toast .close');

    toasts.forEach(btn => btn.addEventListener('click', closeToast));
}

/* ** Affiche les messages du tchat.
* Met à jour les messages affichés.
*
* @param Array messages La liste des messages du tchat.
* */
function renderMessages(messages) {
    let render = '';
    let template;

    messages.forEach(msg => {
        template = `<p class="messages" data-usercolor="${msg['color']}">
            <span>${msg['pseudo']}</span>
            [${msg['date_time']}]
            <span>${msg['message']}</span>
        </p>`;

        render += template;
    });

    document.querySelector('.messagesList .content').innerHTML = render;

    colorizeTexts('.messages');
    colorizeTexts('.user');
}

/* ** Récupère les messages du tchat via l'API du site.
* */
function getAllMessages() {
    let headers = new Headers();

    let options = {
        method: 'GET',
        headers: headers
    };

    fetch('http://minichat.dev.local/api.php?messages')
    .then(result => result.json())
    .then(renderMessages);
}

colorizeTexts('.messages');
colorizeTexts('.user');
hideToast();

setInterval(getAllMessages, 3000);
