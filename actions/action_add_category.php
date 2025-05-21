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
    $db = getDatabase();
    $category = htmlspecialchars($_POST['category_name']);
    addCategory($db,$category);
    header('Location: ../pages/settings.php');



?>