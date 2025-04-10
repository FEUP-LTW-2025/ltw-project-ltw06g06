<?php

declare(strict_types = 1);

function getDatabase(): PDO {
   $db = new PDO('sqlite:proj.db');
   $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   return $db;
}

function getCategories(){
   $db = getDatabase();
   $stmt = $db->prepare('SELECT * FROM categories');
   $stmt->execute();
   $categories = $stmt->fetchAll();
   return $categories;
}

?>