<?php
declare(strict_types = 1);
session_start();

require_once('../database/database.db.php');
require_once('../database/user.class.php');
require_once('../templates/common.tpl.php');

$db = getDatabase();
$user = User::getUser($_SESSION['username']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newName = $_POST['name'];
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];

    $profilePicturePath = $user->pfp;

    
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = basename($_FILES['profile_picture']['name']);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadDir = '../uploads/profile_pictures/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $newFileName = uniqid('pfp_', true) . '.' . $fileExtension;
            $destPath = $uploadDir . $newFileName;
            move_uploaded_file($fileTmpPath, $destPath);
            $profilePicturePath = $destPath;
        }
    }


    if (!empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $db->prepare('UPDATE users SET fullname = ?, username = ?, email = ?, profileP = ?, password = ? WHERE username = ?');
        $stmt->execute([$newName, $newUsername, $newEmail, $profilePicturePath, $hashedPassword, $user->username]);
    } else {
        $stmt = $db->prepare('UPDATE users SET fullname = ?, username = ?, email = ?, profileP = ? WHERE username = ?');
        $stmt->execute([$newName, $newUsername, $newEmail, $profilePicturePath, $user->username]);
    }

    $_SESSION['username'] = $newUsername;
    header('Location: profile.php');
    exit();
}

drawMainHeader(array());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/profilestyle.css">
    <title>Edit Profile</title>
</head>
<body>
<header><h2>Edit Profile</h2></header>
<form method="POST" action="edit_profile.php" enctype="multipart/form-data">
    <section id='profile'>
        <img src="<?= htmlspecialchars($user->pfp) ?>" alt="profile picture">
        <div id='UserInfo'>
            <p>Name: <input type="text" name="name" value="<?= htmlspecialchars($user->name) ?>"></p>
            <p>Username(login): <input type="text" name="username" value="<?= htmlspecialchars($user->username) ?>"></p>
            <p>Email: <input type="email" name="email" value="<?= htmlspecialchars($user->email) ?>"></p>
            <p>Password: <input type="password" name="password" placeholder="Change password "></p>
            <p>Profile Picture: <input type="file" name="profile_picture" accept="image/*"></p>
            <button type="submit" id="saveProfileBtn">Save Changes</button>
        </div>
    </section>
</form>
</body>
</html>
<?php
drawFooter();
?>
