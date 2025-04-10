<?php

    session_start();

    require_once('database/database.db.php');

    $db = getDatabase();

    if (userExists($db, $_POST['username'], $_POST['password'])){
        $_SESSION['username'] = $_POST['username'];  
    }    
    header('Location: index.php' ); 


?>