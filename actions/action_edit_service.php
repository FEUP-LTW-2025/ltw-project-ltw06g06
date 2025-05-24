<?php

    declare(strict_types = 1);

    session_start();

    require_once('../database/database.db.php');
    require_once('../database/service.class.php');
    require_once('../database/user.class.php');

        $db = getDatabase();
        $text = $_POST['description'];
        $name = $_POST['name'];
        $price = (int)$_POST['cost'];
        $time = (float)$_POST['avgTime'];
        $serviceId = (int)$_POST['id'];
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
        if (!preg_match('/^[a-zA-Z0-9_ ,.\']{1,100}$/', $name)) {
        $error = "Name cannot contain special characters.";
    }   

    else if (isServiceNameTaken($db, $name)){
        $error = "Service Name is taken.";
    } 

    else if(!preg_match('/^[a-zA-Z0-9_ ,.\']{1,400}$/', $text)){
        $error = "Description cannot be larger than 400 characters and cannot contain special characters.";
    }

    else if(editService($db, $serviceId, $text,  $price, $time, $name)){
        header('Location: ../pages/service.php?id='. $serviceId);
        exit();
    }
    header('Location: ../pages/edit_service.php?id='. $serviceId . "&error=" . $error . "#editServiceForm");
    exit();




?>

