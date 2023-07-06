<?php

require_once('models.php');

/* ** Affiche les vues dans index.php
* 
* @param Array $views La liste des vues à affichés sur la page.
* @param String $title Le titre de la page, affiché dans l'onglet du navigateur.
* */
function showPage($views = ['chat'], $title = 'Tchat en direct') {
    include('includes/header.php');

    foreach($views as $view) {
        include('pages/' . $view . '.php');
    }

    include('includes/footer.php');
}

/* ** Routeur pour afficher toutes les pages du site sur index.php
* */
function router() {
    $pagesAvailables = ['chat'];

    if (!isset($_GET['page'])) {
        showPage(['chat']);
    } else {
        if (!empty($_GET['page'])) {
            switch ($_GET['page']) {
                case 'chat':
                    showPage(['chat']);
                    break;
                default:
                    showPage(['chat']);
            } 
        } else {
            showPage(['chat']);
        }
    }
}

/* ** Affiche la liste des messages dans la page chat.php
* */
function showAllMessages() {
    $allMessages = getAllMessages();

    if (count($allMessages) > 0) {
        foreach($allMessages as $msg) {
            include('includes/single-message.php');
        }
    } else {
        include('includes/no-messages.hp');
    }
}

/* ** Affiche la liste des membres dans la page chat.php
* Seuls les memnres actis sont affichés, 
* c-a-d les membres ayant envoyés un message dans les 5 dernières minutes.
* */
function showConnectedUsers() {
    $HTMLUsers = '';
    $connectedMembers = getConnectedUsers();

    if (count($connectedMembers) > 0) {
        foreach($connectedMembers as $user) {
            $HTMLUsers .= '<p>' . $user['pseudo'] . '</p>';
        }
    } else {
        $HTMLUsers .= '<p>Aucun utilisateur connecté pour le moment.</p>';
    }

    return $HTMLUsers;
}

?>
