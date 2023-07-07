<?php

session_start();

$statusSendingMessage = verifyFormMessage();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Minichat - <?= $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <a href="/"><h1>Minichat</h1></a>
        <nav>
            <ul>
                <li><a href="index.php?page=signin">Inscription</a></li>
                <li><a href="index.php?page=login">Connexion</a></li>
            </ul>
        </nav>
    </header>
