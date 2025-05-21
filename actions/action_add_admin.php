<?php
   
    declare(strict_types=1);
    session_start();


    require_once('../database/database.db.php');

    if (!isset($_SESSION['username'])) {
        header('Location: ../pages/index.php');
        exit();
    }
    if(($_SESSION['csrf']) != $_POST['csrf']){
        header('Location: ../pages/settings.php');
        exit();
    }
    if (!isset($_POST['user_ids']) || !is_array($_POST['user_ids'])) {
        die('No users selected.');
    }

    $db = getDatabase();
    setUsersAdmin($db,$_POST['user_ids']);
    header('Location: ../pages/settings.php');
?>