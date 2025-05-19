<?php
session_start();

require_once('../database/database.db.php');
require_once('../database/user.class.php'); 

$db = getDatabase();
$name = $_POST['name'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

try {
    if (registerUser($db, $name, $username, $password, $email)) {
        $_SESSION['username'] = $username;
        header('Location: ../index.php');
        exit();
    }
} catch (Exception $e) {
    
    $error = urlencode($e->getMessage());
    header("Location: ../register.php?error=$error");
    exit();
}
?>
