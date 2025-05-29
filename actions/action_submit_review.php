<?php 
    declare(strict_types = 1);
    session_start();

    require_once('../database/database.db.php');
    require_once("../database/user.class.php");

    $db = getDatabase();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = htmlspecialchars($_SESSION['username']);
        $rating = (int) $_POST['rating'];
        $description = htmlspecialchars($_POST['description']);
        if(!preg_match('/^[a-zA-Z0-9_ ?:!()-,.\']{1,10000}$/', $description)){
            $error = "Description cannot be larger than 10000 characters and cannot contain special characters.";
            header('Location: ../pages/service.php?id=' . urlencode($_POST['service']) . '&error=' . urlencode($error) . '#review-form');
            exit();
        }
        $user = User::getUser($username);
        saveReview($db,$user->id,$rating,$description,(int)$_POST['service']);
        header("Location: ../pages/service.php?id=" . $_POST['service']);
    }
    exit();
?>
    