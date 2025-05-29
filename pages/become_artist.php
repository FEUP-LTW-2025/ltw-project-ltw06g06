<?php
  declare(strict_types=1);
  session_start();

  require_once('../database/database.db.php');
  require_once('../templates/common.tpl.php');

  $db = getDatabase();
  $categories = getCategories($db);

  if (!isset($_SESSION['userId'])) {
    header('Location: ../pages/login.php#login');
    exit();
  }

  drawMainHeader($categories);
  drawBecomeArtists($categories);
  drawFooter();

?>
