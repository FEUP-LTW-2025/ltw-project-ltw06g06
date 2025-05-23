<?php
   declare(strict_types = 1);
   session_start();

   require_once('../database/database.db.php');
   require_once('../templates/common.tpl.php');
   require_once('../templates/auth.tpl.php');


   $db = getDatabase();
   $categories = getCategories();
   drawMainHeader($categories);
   drawRegisterForm();
   drawFooter();


?>