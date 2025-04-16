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

 function isUsernameTaken(PDO $db, string $username): bool {
   $stmt = $db->prepare('SELECT 1 FROM users WHERE username = ?');
   $stmt->execute([$username]);
   return $stmt->fetch() !== false;
}

 function registerUser(PDO $db,  string $username, string $password,  string $email){

   if (isUsernameTaken($db, $username)) {
      throw new Exception("Username already exists.");
   }

   $stmt = $db->prepare('INSERT INTO users (username, password, email, profileP) VALUES (?,?,?,?)');
   $stmt->execute([$username, $password, $email,'default.png']);
   $userId = $db->lastInsertId();
   $stmt = $db->prepare('INSERT INTO Client (clientId, isAdmin) VALUES (?, ?)');
   $stmt->execute([$userId, 0]);
   
   return true;
}

?>