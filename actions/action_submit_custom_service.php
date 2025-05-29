<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/database.db.php');
    require_once('../database/service.class.php');
    require_once('../database/user.class.php');


    if(!isset($_SESSION['username'])) {
        header('Location: ../pages/index.php');
        exit();
    }

    $db = getDatabase();
    $text = $_POST['description'];
    $name = $_POST['name'];
    $price = $_POST['cost'];
    $artist = $_POST['artistId'];
    $user = $_SESSION['userId'];
    $image = null;


    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/service_pictures/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // Create the directory if it doesn't exist
        }

        $tmpName = $_FILES['image']['tmp_name'];
        $originalName = basename($_FILES['image']['name']);
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        // Validate file type (optional)
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($ext, $allowedExts)) {
            die("Unsupported file type.");
        }

        $newFileName = uniqid('img_', true) . '.' . $ext;
        $targetPath = $uploadDir . $newFileName;

        if (move_uploaded_file($tmpName, $targetPath)) {
            $imagePath = '../uploads/service_pictures/' . $newFileName;
            echo "Image uploaded successfully.<br>";
            $image = $imagePath;
        } else {
            die("Failed to move uploaded file.");
        }
    }

    if(($_SESSION['csrf']) != $_POST['csrf']){
        header('Location: ../pages/index.php');
        exit();
    }

    
    if (!preg_match('/^[a-zA-Z0-9_ ?:!()-,.\']{1,200}$/', $name)) {
        $error = "Name cannot contain special characters.";
    }   

    else if(!preg_match('/^[a-zA-Z0-9_ ?:!()-,.\']{1,10000}$/', $text)){
        $error = "Description cannot be larger than 10000 characters and cannot contain special characters.";
    }

    else{
        createCustomService($db,(int) $artist,(int) $user, $text,$name, $image,(float)$price);
        header('Location: ../pages/artist.php?id='.$artist);
        exit();
    }
    header('Location: ../pages/customService.php?error=' . urlencode($error) ."&id=" . urlencode($artist) . "#scroll-form");
?>