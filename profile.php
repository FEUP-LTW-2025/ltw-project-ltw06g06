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
      <link rel="stylesheet" href="css/profilesytle.css">
      <title>Profile</title>
   </head>
   <header><h1>Profile</h1></header>
   <body>
    <section id='profile'>
        <img src="<?= $user->pfp ?>" alt="profile picture">
        <p> Username: <?= $user->username ?></p>
        <p> Email: <?= $user->email ?></p>

    </section> 
   </body>
</html>
<?php
?>