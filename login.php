<?php

    declare(strict_types = 1);
    session_start();

    require_once('database/database.db.php');
    require_once('templates/common.tpl.php');

    $db = getDatabase();
    $categories = getCategories();
    drawMainHeader($categories);

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8"> 
      <link rel="stylesheet" href="css/loginstyle.css">
      <title>Login</title>
   </head>

   <body>
    <form id='login' action="actions/action_login.php" method='post'>
      <h3>Name:</h3>
      <input type="text" name="username" placeholder="Enter your name">

      <h3>Password:</h3>
      <input type="password" name="password" placeholder="Enter your password">

      <br><br>
      <button onclick="window.location.href='home.html'">Login</button>
      <h3> If you don't have an account :</h3>
      <a href="register.php"> Register </button> </a>
</form>
   </body>
</html>

<?php

drawFooter();

?>