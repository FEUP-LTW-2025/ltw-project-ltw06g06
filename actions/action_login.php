<?php
    
    declare(strict_types = 1);
    session_start();

    require_once('../database/database.db.php');
    require_once('../database/user.class.php');

    $db = getDatabase();

    
    if (userExists($db, $_POST['username'], $_POST['password'])){
        $_SESSION['username'] = $_POST['username'];
        $user = User::getUser((string)$_POST['username']);
        $_SESSION['userId'] = $user->id;
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
        header('Location: ../index.php' ); 
    }
    else{   
        header('Location: ../login.php');
    }

?>