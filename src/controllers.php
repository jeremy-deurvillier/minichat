<?php

/* ** Affiche une page dans index.php
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

?>
