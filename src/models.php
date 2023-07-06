<?php

require_once('db-connect.php');

/* ** Sélectionne tous les messages.
* */
function getAllMessages() {
    $db = dbConnect();

    $sql = 'SELECT msg.id_message, message, pseudo, u.id_user, date_time, color FROM messages AS msg
        LEFT JOIN users_messages AS umsg ON msg.id_message = umsg.id_message
        LEFT JOIN users AS u ON umsg.id_user = u.id_user
        ORDER BY date_time DESC;';

    $request = $db->query($sql);
    $allMessages = $request->fetchAll(PDO::FETCH_ASSOC);

    return $allMessages;
}

/* ** Sélectionne les utilisateurs ayant envoyer un message dans les 5 dernières minutes.
* */
function getConnectedUsers() {
    $db = dbConnect();

    $sql = 'SELECT * FROM users;';

    $request = $db->query($sql);
    $allUsers = $request->fetchAll(PDO::FETCH_ASSOC);

    return $allUsers;
}

?>
