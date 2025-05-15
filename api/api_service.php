<?php
  declare(strict_types = 1);
  session_start();

  require_once(__DIR__ . '/../database/database.db.php');
  require_once(__DIR__ . '/../database/service.class.php');

  $db = getDatabase();
  $services = Service::searchServices($db, $_GET['search'],(int) $_GET['price'], (float)$_GET['rating']);
  echo json_encode($services);
?>