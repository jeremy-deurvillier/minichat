<?php

$pseudo = (isset($_SESSION['user_pseudo']))?$_SESSION['user_pseudo']:'';

?>
<div id="formMessage">
    <form action="/" method="post">

        <label for="pseudo">Pseudo :</label>
        <input type="text" name="pseudo" value="<?= $pseudo ?>">

        <label for="message">Message :</label>
        <input type="text" name="message" value="">

        <input type="submit" name="sendMessage" value="Envoyer">
    </form>
</div>
