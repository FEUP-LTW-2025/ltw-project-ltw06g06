<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/database.db.php');
    require_once('../database/user.class.php');


    $db = getDatabase();
    $text = $_POST['description'];
    $service = $_POST['service'];
    $user = $_SESSION['username'];
    if(($_SESSION['csrf']) != $_POST['csrf']){
        header('Location: ../pages/request.php?id='.$service);
        exit();
    }
    if(!preg_match('/^[a-zA-Z0-9_ ,.\']{1,400}$/', $text)){
        $error = "Description cannot be larger than 400 characters and cannot contain special characters.";
        header('Location: ../pages/request.php?id='. urlencode($service) . "&error=" . urlencode($error) . "#scroll-form");
        exit();
    }
    $user = User::getUser($user);
    createRequest($db,$text,$user->id,(int)$service);
    header('Location: ../pages/index.php')



?>