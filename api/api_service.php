<?php
  declare(strict_types = 1);
  session_start();

  require_once(__DIR__ . '/../database/database.db.php');
  require_once(__DIR__ . '/../database/service.class.php');

  $db = getDatabase();

  $services = Service::searchServices($db, $_GET['search'], 8);
  echo json_encode($services);
?>