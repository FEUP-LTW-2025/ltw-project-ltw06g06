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
    <form id='login' action="actions/action_register.php" method='post'>
      <h3>Name:</h3>
      <input type="name" name="name" placeholder="Enter your first and last name">

      <h3>Username:</h3>
      <input type="text" name="username" placeholder="Choose your name">

      <h3>Email:</h3>
      <input type="email" name="email" placeholder="Enter your email">
      
      <h3>Password:</h3>
      <input type="password" name="password" placeholder="Choose your password">

      <br><br>
      <button type='submit'>Register</button>
</form>
   </body>
</html>

<?php

drawFooter();


?>