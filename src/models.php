<?php

require_once('db-connect.php');

/* ** Sélectionne tous les messages.
* 
* @return Array Un tableau contenant la liste des messages du tchat.
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
* 
* @return Array Un tableau contenant la liste des utilisateurs ayant envoyer un message dans le 5 dernières minutes.
* */
function getConnectedUsers() {
    $db = dbConnect();

    $sql = 'SELECT * FROM users;';

    $request = $db->query($sql);
    $allUsers = $request->fetchAll(PDO::FETCH_ASSOC);

    return $allUsers;
}

/* ** Vérifie si un utilisateur existe.
* 
* @param String $pseudo Un pseudo à tester.
*
* @return Array|Boolean Un tableau contenant les informations d'un utilisateur s'il existe, false sinon.
* */
function userExist($pseudo) {
    $db = dbConnect();

    $sql = 'SELECT id_user, pseudo FROM users WHERE pseudo = :pseudo;';

    $request = $db->prepare($sql);
    $request->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $request->execute();
    $user = $request->fetch(PDO::FETCH_ASSOC);

    return $user;
}

/* ** Récupère le dernier id auto-incrémenté d'un table.
* 
* @param String $column Le nom de la colonne auto-incrémenté à sélectionner.
* @param String $table Le nom de la table sur laquelle travailler.
*
* @return Int Le dernier id auto-incrémenté d'une table.
* */
function getLastIDInsert($column, $table) {
    $db = dbConnect();

    $request = $db->query('SELECT MAX(' .  $column. ') AS id FROM ' . $table . ';');
    $lastId = $request->fetch(PDO::FETCH_ASSOC);

    return $lastId['id'];
}

/* ** Crée une nouvelle adresse IP dans la base.
* 
* @param Int $user L'id unique d'un utilisateur.
*
* @return Int Un code d'erreur ou de succès.
* */
function createNewIpAddress($user) {
    $db = dbConnect();

    try {
      $requestIp = $db->prepare('INSERT INTO ip_address (ip_address) VALUES (:ip)');
      $requestIp->bindValue(':ip', $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
      $requestIp->execute();

      $lastIpId = getLastIDInsert('id_ip_address', 'ip_address');

      $requestUsersIp = $db->prepare('INSERT INTO users_ip_address (id_user, id_ip_address) VALUES (:user, :ip)');
      $requestUsersIp->bindValue(':user', $user, PDO::PARAM_INT);
      $requestUsersIp->bindValue(':ip', $lastIpId, PDO::PARAM_INT);
      $requestUsersIp->execute();

      return 0;
    } catch (Exception $error) {
        return 1;
    }
}

/* ** Crée un nouvel utilisateur dans la base.
* 
* @param String $pseudo Le pseudo de l'utilisateur.
* @param String $color La couleur par défaut de l'utilisateur.
* @param String $password Le mot de passe de l'utilisateur. Par défaut, vaut 'null'.
*
* @return Int Retourne toujours 0.
* */
function createUser($pseudo, $color, $password = 'null') {
    $db = dbConnect();

    $requestUsers = $db->prepare('INSERT INTO users (pseudo, password, create_at, color) VALUES (:pseudo, :passw, NOW(), :color)');
    $requestUsers->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $requestUsers->bindValue(':passw', $password, PDO::PARAM_STR);
    $requestUsers->bindValue(':color', $color, PDO::PARAM_STR);
    $requestUsers->execute();

    return 0;
}

/* ** Crée un nouveau message.
* 
* @param String $msg Le message d'un utilisateur.
* @param Int $user L'id unique d'un utilisateur.
*
* @return Int Un code d'erreur ou de succès.
* */
function createNewMessage($msg, $user) {
  $db = dbConnect();
  $lastMessageId;

  try {
      $requestMessages = $db->prepare('INSERT INTO messages (message) VALUES (:message)');
      $requestMessages->bindValue(':message', $msg, PDO::PARAM_STR);
      $requestMessages->execute();

      $lastMessageId = getLastIDInsert('id_message', 'messages');

      $requestUsersMessages = $db->prepare('INSERT INTO users_messages (id_user, id_message, date_time) VALUES (:user, :message, NOW())');
      $requestUsersMessages->bindValue(':user', $user, PDO::PARAM_INT);
      $requestUsersMessages->bindValue(':message', $lastMessageId, PDO::PARAM_INT);
      $requestUsersMessages->execute();

      return 0;
  } catch (Exception $error) {
    return 1;
  }
}

?>
