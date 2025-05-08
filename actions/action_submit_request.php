<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/database.db.php');
    require_once('../database/user.class.php');


    $db = getDatabase();
    $text = $_POST['description'];
    $service = $_POST['service'];
    $user = $_SESSION['username'];
    $user = User::getUser($user);
    createRequest($db,$text,$user->id,(int)$service);
    header('Location: ../index.php')



?>