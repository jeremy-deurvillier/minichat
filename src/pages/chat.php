<?php


if ($statusSendingMessage !== NULL) toast($statusSendingMessage, 'sendmessage');

?>
<div id="tchat">
    <section class="messagesList">
        <h2>Messages</h2>
        <div class="content">
            <?php showAllMessages(); ?>
        </div>
    </section>
    <aside class="usersList">
        <h2>Membres connectés</h2>
        <div class="content">
            <?= showConnectedUsers(); ?>
        </div>
    </aside>
</div>
<?php include('../includes/message-form.php'); ?>
