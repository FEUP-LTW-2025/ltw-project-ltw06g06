<?php

declare(strict_types = 1);

function getDatabase(): PDO {
   $db = new PDO('sqlite:'. __DIR__ .'/proj.db');
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
   $stmt = $db->prepare('SELECT * FROM Users WHERE users.username = ?');
   $stmt->bindParam(1, $username);
   $stmt->execute();
   $user = $stmt->fetch();
    if($user == null){
        return false;
    }
   if(password_verify($password,$user['password'])){
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

 function registerUser(PDO $db,string $name  ,string $username, string $password,  string $email){

   if (isUsernameTaken($db, $username)) {
      throw new Exception("Username already exists.");
   }

   $stmt = $db->prepare('INSERT INTO users (fullname, username, password, email, profileP) VALUES (?,?,?,?,?)');
   $stmt->execute([$name,$username, password_hash($password,PASSWORD_DEFAULT), $email,'default.png']);
   $userId = $db->lastInsertId();
   $stmt = $db->prepare('INSERT INTO Client (clientId, isAdmin) VALUES (?, ?)');
   $stmt->execute([$userId, 0]);
   
   return true;
}

   function saveReview(PDO $db, int $userId,float $rating,string $comment, int $serviceId): void {
      $stmt = $db->prepare('
          INSERT INTO Review (clientId, serviceId, comment, rating, date)
          VALUES (?, ?, ?, ?, ?)
      ');
  
      $stmt->execute([
          $userId,
          $serviceId,
          $comment,
          $rating,
          date('Y-m-d')
      ]);
      updateRating($db,$serviceId);
   }

   function updateRating(PDO $db, int $serviceId){
      $stmt = $db->prepare('
        SELECT AVG(rating) as avg_rating
        FROM Review
        WHERE serviceId = ?
    ');
    $stmt->execute([$serviceId]);
    $result = $stmt->fetch();
    if ($result && $result['avg_rating'] !== null) {
        $averageRating = round((float)$result['avg_rating'], 1);
        $update = $db->prepare('
            UPDATE Service
            SET rating = ?
            WHERE serviceId = ?
        ');
        $update->execute([
            $averageRating,
            $serviceId
        ]);
    }

   }
   function createRequest(PDO $db, String $text, int $uid, int $sid){
      $stmt = $db->prepare('
        INSERT INTO Request (description, clientId, serviceId, status ,date)
        VALUES (?, ?, ?, "PENDING", ?)
    ');
    $stmt->execute([$text, $uid, $sid,date('Y-m-d')]);
    updateService($db,$sid);
   }
   function updateService(PDO $db, int $serviceId){
      $stmt = $db->prepare('
        SELECT COUNT(*) as count
        FROM Request
        WHERE serviceId = ?
    ');
    $stmt->execute([$serviceId]);
    $result = $stmt->fetch();
    if ($result && $result['count'] !== null) {
        $update = $db->prepare('
            UPDATE Service
            SET requests = ?
            WHERE serviceId = ?
        ');
        $update->execute([
            $result['count'],
            $serviceId
        ]);
    }

   }

   function isArtist(string $username): bool {
      if($username == null){
            return false;
        }
      $db = getDatabase();
      $stmt = $db->prepare('SELECT 1 FROM Users U JOIN Artist A ON U.id = A.artistId WHERE U.username = ?');
      $stmt->bindParam(1, $username);
      $stmt->execute();
      return $stmt->fetch() !== false;
   }

   function isAdmin(string $username): bool {
      if($username == null){
            return false;
        }
      $db = getDatabase();
      $stmt = $db->prepare('SELECT 1 FROM Users U JOIN Client C ON U.id = C.clientId WHERE U.username = ? AND C.isAdmin = 1');
      $stmt->bindParam(1, $username);
      $stmt->execute();
      return $stmt->fetch() !== false;
   }

   function updateArtist(PDO $db, int $artistId): void {
      $stmt = $db->prepare('
          SELECT avg(rating) as total_rating
          FROM Service
          WHERE artistId = ?
      ');
  
      $stmt->execute([$artistId]);
      $result = $stmt->fetch();
      if ($result && $result['total_rating'] !== null) {
          $totalRating = round((float)$result['total_rating'], 2);
          $update = $db->prepare('
              UPDATE Artist
              SET rating = ?
              WHERE artistId = ?
          ');
          $update->execute([
              $totalRating,
              $artistId
          ]);
      }
   }

   function userBoughtService(PDO $db, int $uid, int $sid): bool {
      $stmt = $db->prepare('SELECT 1 FROM Users U JOIN Client C ON U.id = C.clientId JOIN Request R ON R.clientId = C.clientId WHERE U.id = ? AND R.serviceId = ? AND R.status = "COMPLETE"');
      $stmt->bindParam(1, $uid);
      $stmt->bindParam(2, $sid);
      $stmt->execute();
      return $stmt->fetch() !== false;
   }
?>