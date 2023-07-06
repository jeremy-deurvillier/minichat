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

/* ** 
* */
function userExist($pseudo) {
    $db = dbConnect();

    $sql = 'SELECT pseudo FROM users WHERE pseudo = :pseudo;';

    $request = $db->prepare($sql);
    $request->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $request->execute();
    $user = $request->fetch(PDO::FETCH_ASSOC);

    return (is_array($user))?true:false;
}

/* ** 
* */
function getLastIDInsert($column, $table) {
    $db = dbConnect();

    $request = $db->query('SELECT MAX(' .  $column. ') AS id FROM ' . $table . ';');
    $lastId = $request->fetch(PDO::FETCH_ASSOC);

    return $lastId['id'];
}


/* ** 
* */
function createNewMessage($pseudo, $msg) {
  $db = dbConnect();
  $lastUserId;
  $lastMessageId;

  try {
    if (!userExist($pseudo)) {
      $requestUsers = $db->prepare('INSERT INTO users (pseudo, create_at, color) VALUES (:pseudo, NOW(), :color)');
      $requestUsers->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
      $requestUsers->bindValue(':color', $color, PDO::PARAM_STR);
      $requestUsers->execute();

      $lastUserId = getLastIDInsert('id_user', 'users');

      $requestMessages = $db->prepare('INSERT INTO messages (message) VALUES (:message)');
      $requestMessages->bindValue(':message', $msg, PDO::PARAM_STR);
      $requestMessages->execute();

      $lastMessageId = getLastIDInsert('id_message', 'messages');

      $requestUsersMessages = $db->prepare('INSERT INTO users_messages (id_user, id_message, date_time) VALUES (:user, :message, NOW())');
      $requestUsersMessages->bindValue(':user', $lastUserId, PDO::PARAM_INT);
      $requestUsersMessages->bindValue(':message', $lastMessageId, PDO::PARAM_INT);
      $requestUsersMessages->execute();

      return 0;
    } else {
      return 2;
    }
  } catch (Exception $error) {
    return 1;
  }
}

?>
