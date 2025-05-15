<?php


declare(strict_types = 1);
session_start();

require_once('database/database.db.php');
require_once('database/service.class.php');
require_once('database/user.class.php');
require_once('templates/common.tpl.php');
require_once('templates/request.tpl.php');
require_once('database/request.class.php');



$db = getDatabase();
drawMainHeader(array());
$user = User::getUser($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8"> 
      <title>Profile</title>
   </head>
   <body>
    <header><h2 id="ProfileTitle" >Profile</h2></header>
            <section id='profile'>
               <div id="profileHeader">
                  <form action="edit_profile.php" method="get">
                        <button type="submit" id="editProfileBtn">Edit Profile</button>
                  </form>
               </div>

               <img src="<?= $user->pfp ?>" alt="profile picture">

               <div id='UserInfo'>
                  <p><strong>Name:</strong> <?= htmlspecialchars($user->name) ?></p>
                  <p><strong>Username:</strong> <?=  htmlspecialchars($user->username) ?></p>
                  <p><strong>Email:</strong> <?=  htmlspecialchars($user->email) ?></p>
               </div>
            </section>


   </body>
</html>
<?php

$requests = Request::getPendingRequestsFromUser($user->id);
drawPendingRequests($requests);
drawFooter();

?>