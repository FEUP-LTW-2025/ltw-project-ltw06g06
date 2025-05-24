<?php
    
    declare(strict_types = 1);
    session_start();

    require_once('../database/database.db.php');
    require_once('../database/user.class.php');

    $db = getDatabase();

    $error = "";
    if (!isset($_POST['username'], $_POST['password']) || empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
        $error = "Username and password cannot be empty";
    }

    else if (userExists($db, $_POST['username'], $_POST['password'])){
        $_SESSION['username'] = $_POST['username'];
        $user = User::getUser((string)$_POST['username']);
        $_SESSION['userId'] = $user->id;
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        header('Location: ../pages/index.php' ); 
        exit();
    }
    else{   
        $error = "Invalid username or password. Please try again.";
    }

    header('Location: ../pages/login.php?error=' . $error);


?>