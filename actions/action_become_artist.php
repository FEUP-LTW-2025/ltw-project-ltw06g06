<?php
declare(strict_types=1);
session_start();

require_once('../database/database.db.php');

// ensure the user is logged in by checking username
if (!isset($_SESSION['username'])) {
  header('Location: ../login.php');
  exit();
}

$db = getDatabase();

// get form data
$description = $_POST['bio'] ?? '';
$category = $_POST['category'] ?? '';
$username = $_SESSION['username'];
$rating = 0.0; // Initial artist rating

// validate form input
if (trim($description) === '' || trim($category) === '') {
  header('Location: ../become_artist.php?error=missing_fields');
  exit();
}

// fetch user ID using username
$stmt = $db->prepare('SELECT id FROM Users WHERE username = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();

if (!$user) {
  header('Location: ../login.php');
  exit();
}

$artistId = $user['id'];

// check if user is already an artist
$stmt = $db->prepare('SELECT 1 FROM Artist WHERE artistId = ?');
$stmt->execute([$artistId]);
if ($stmt->fetch()) {
  header('Location: ../profile.php?error=already_artist');
  exit();
}

// insert artist into table
$stmt = $db->prepare('
  INSERT INTO Artist (artistId, rating, category, description)
  VALUES (?, ?, ?, ?)
');
$stmt->execute([$artistId, $rating, $category, $description]);

// redirect on success
header('Location: ../index.php?artist=created');
exit();
