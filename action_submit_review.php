<?php 

    session_start();

    require_once("database/database.db.php");
    require_once("database/user.class.php");

    $db = getDatabase();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = htmlspecialchars($_SESSION['username']);
        $rating = (int) $_POST['rating'];
        $description = htmlspecialchars($_POST['description']);
        var_dump($_POST['service']);
        $user = User::getUser($username);
        saveReview($db,$user->id,$rating,$description,$_POST['service']);
        header("Location: service.php?id=" . $_POST['service']);
    }
?>
    