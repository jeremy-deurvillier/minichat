<?php

require_once('../models.php');

/* ** Retourne tous les messages au format JSON.
* 
* @return JSON La liste de tous les messages.
* */
function json_getAllMessages() {
    $allMessages = getAllMessages();

    return json_encode($allMessages);
}

if (isset($_GET['messages'])) echo json_getAllMessages();

?>
