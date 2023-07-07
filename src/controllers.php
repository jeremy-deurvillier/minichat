<?php

require_once('errors-messages.php');
require_once('vendor/RandomColor.php');
require_once('models.php');

use \Colors\RandomColor;

/* ** Affiche un message de notification dans la page.
* Affiche les messages de succès et d'erreurs.
* 
* @param Int $status Un code d'erreur ou de succès.
* @param String $action L'action qui à générer l'erreur (send message, connexion, inscription)
* */
function toast($status, $action) {
  global $errorsList;

  $message = $errorsList[$action][$status];

  include('includes/toast.php');
}

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
        include('includes/no-messages.php');
    }
}

/* ** Affiche la liste des utlisateurs dans la page chat.php
* Seuls les utilisateurs actifs sont affichés, 
* c-a-d les membres ayant envoyés un message dans les 5 dernières minutes.
*
* @return HTMLNodeList Un noeud DOM à insérer dans la page.
* */
function showConnectedUsers() {
    $HTMLUsers = '';
    $connectedMembers = getConnectedUsers();

    if (count($connectedMembers) > 0) {
        foreach($connectedMembers as $user) {
            $HTMLUsers .= '<p class="user" data-usercolor="' . $user['color'] . '">' . $user['pseudo'] . '</p>';
        }
    } else {
        $HTMLUsers .= '<p>Aucun utilisateur connecté pour le moment.</p>';
    }

    return $HTMLUsers;
}

/* ** Vérifie le formulaire d'envoi de message dans le tchat.
* 
* @return Int Un code d'erreur ou de succès.
* */
function verifyFormMessage() {
  $userIsSaved;
  $lastUserId;
  $currentUser;

  $pseudoIsOk = (isset($_POST['pseudo']) && !empty($_POST['pseudo']));
  $messageIsOk = (isset($_POST['message']) && !empty($_POST['message']));

  if (count($_POST) > 0) {
      if ($pseudoIsOk && $messageIsOk) {
          $currentUser = userExist($_POST['pseudo']);
      
          if ($currentUser === false) {
              $userIsSaved = createUser($_POST['pseudo'], RandomColor::one());

              if ($userIsSaved === 0) {
                  $lastUserId = getLastIDInsert('id_user', 'users');
                  $ipIsSaved = createNewIpAddress($lastUserId);

                  $_SESSION['user_pseudo'] = $_POST['pseudo'];
                  $_SESSION['user_id'] = $lastUserId;
              }
          } else {
              $_SESSION['user_pseudo'] = $currentUser['pseudo'];
              $_SESSION['user_id'] = $currentUser['id_user'];
          }

          $messageIsSaved = createNewMessage($_POST['message'], $_SESSION['user_id']);

          if ($messageIsSaved === 0) {
            return 0;
          }

          return 2;
    } else {
      return 1;
    }
  }
}

?>
