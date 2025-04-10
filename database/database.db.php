<?php

declare(strict_types = 1);

function getDatabase(): PDO {
   $db = new PDO('sqlite:proj.db');
   $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   return $db;
}

function getCategories(): array {
   $db = getDatabase();
   $stmt = $db->prepare('SELECT * FROM category');
   $stmt->execute();
   $categories = array();
   $categories = $stmt->fetchAll();
   return $categories;
}

function userExists(PDO $db, string $username, string $password){
   $stmt = $db->prepare('SELECT * FROM users WHERE users.username = ?');
   $stmt->bindParam(1, $username);
   $stmt->execute();
   $user = $stmt->fetch();
   if($user['password'] === $password){
      return true;
   }
   else{
      return false;
   }

 }

?>