<?php
    session_start();

    require_once("database/database.db.php");

    $db = getDatabase();
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if(registerUser($db,$username,$password,$email)){
        $_SESSION['username'] = $username;
        header('Location: index.php');
    }
    else{
        header('Location: register.php');
    }

?>