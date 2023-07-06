<?php

$statusSendingMessage = verifyFormMessage();

if ($statusSendingMessage !== NULL) toast($statusSendingMessage, 'sendmessage');

?>
<section>
    <h2>Messages</h2>
    <div class="">
        <?php showAllMessages(); ?>
    </div>
</section>
<aside>
    <h2>Membres connectés</h2>
    <div class="">
        <?= showConnectedUsers(); ?>
    </div>
</aside>
<?php include('../includes/message-form.php'); ?>
