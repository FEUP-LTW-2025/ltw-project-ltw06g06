<?php
declare(strict_types = 1);
session_start();

require_once('../database/database.db.php');
require_once('../database/service.class.php');
require_once('../database/user.class.php');

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    header('Location: ../index.php');
    exit();
}

$db = getDatabase();
$text = $_POST['description'];
$category = $_POST['category'];
$time = $_POST['avgtime'];
$name = $_POST['name'];
$cost = $_POST['cost'];
$artist = $_SESSION['userId'];
$image = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../uploads/service_pictures/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $tmpName = $_FILES['image']['tmp_name'];
    $originalName = basename($_FILES['image']['name']);
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array($ext, $allowedExts)) {
        die("Unsupported file type.");
    }

    $newFileName = uniqid('img_', true) . '.' . $ext;
    $targetPath = $uploadDir . $newFileName;

    if (move_uploaded_file($tmpName, $targetPath)) {
        $image = 'uploads/service_pictures/' . $newFileName;
    } else {
        die("Failed to move uploaded file.");
    }
}

$image ??= '';


$serviceID = createService($db, (float)$cost, $image, (int)$artist, $name, $category, $text, (int)$time);

header('Location: ../service.php?id=' . $serviceID);
exit();
