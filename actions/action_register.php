<?php
    declare(strict_types = 1);

    session_start();

    require_once('../database/database.db.php');
    require_once('../database/user.class.php');

    $db = getDatabase();
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $error = "";

    if (!preg_match('/^[a-zA-Z0-9_ ]{1,100}$/', $_POST['name'])) {
        $error = "Name cannot contain special characters.";
    }    

    else if (!preg_match('/^[a-zA-Z0-9_]{1,20}$/', $_POST['username'])) {
        $error = "Username must be less than 20 characters and cannot contain special characters.";
    }    
    else if(strlen($password) < 5){
        $error = "Password has to be larger than 5 characters.";

    }
    else if(isEmailTaken($db, $email)){
        var_dump($email);
        $error = "Email already in use";
    }
    else if(registerUser($db,$name,$username,$password,$email)){
        $_SESSION['username'] = $username;
        $user = User::getUser($username);
        $_SESSION['userId'] = $user->id;
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        header('Location: ../pages/index.php');
        exit();
    }
    else{
        $error ="Username taken";
    }
    
    header('Location: ../pages/register.php?error=' .$error );


?>