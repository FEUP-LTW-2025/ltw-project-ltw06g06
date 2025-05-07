<?php


declare(strict_types = 1);
session_start();

require_once('database/database.db.php');
require_once('database/service.class.php');
require_once('database/user.class.php');
require_once('templates/common.tpl.php');

$db = getDatabase();
drawMainHeader(array());
$user = User::getUser($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8"> 
      <link rel="stylesheet" href="css/profilestyle.css">
      <title>Profile</title>
   </head>
   <body>
    <header><h2>Profile</h2></header>
    <section id='profile'>
        <img src="<?= $user->pfp ?>" alt="profile picture">
         <div id='UserInfo'>
            <p> Name: <?= $user->name ?></p>
            <p> Username: <?= $user->username ?></p>
            <p> Email: <?= $user->email ?></p>
            <button id="editProfileBtn">Edit Profile</button>
         </div>
    </section> 
   </body>
</html>
<?php

drawFooter();

?>