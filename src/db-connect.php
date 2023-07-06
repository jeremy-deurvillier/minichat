<?php
function dbConnect() {
    $dns = 'mysql:host=172.16.238.12;dbname=minichat';
    $user = 'root';
    $password = '';
    $db;

    try {
        $db = new PDO($dns, $user, $password);

    } catch (Exception $error) {
        echo '<p>Une erreur est survenue.</p>';

        var_dump($error);
    }

    return $db;
}

?>
