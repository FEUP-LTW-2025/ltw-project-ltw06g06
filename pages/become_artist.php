<?php
  declare(strict_types=1);
  session_start();

  require_once('../database/database.db.php');
  require_once('../templates/common.tpl.php');

  $db = getDatabase();
  $categories = getCategories($db);

  drawMainHeader($categories);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Artist Registration</title>
</head>
<body>
  <section class="service-request-form">
  <h2>Become an Artist</h2>

  <form action="../actions/action_become_artist.php" method="post">
    
    <div class="form-group">
      <label for="bio">Brief Description of Yourself:</label>
      <textarea name="bio" id="bio" rows="5" required placeholder="Tell us a bit about you, your skills, and what you offer."></textarea>
    </div>

    <div class="form-group">
      <label for="category">Category:</label>
      <select name="category" id="category" required>
      <option value="">Select a Category </option>
      <?php foreach ($categories as $cat) {
        $id = $cat['id'] ?? '';
        $name = $cat['name'] ?? 'Unnamed';
      ?>
        <option value="<?= htmlspecialchars((string)$cat['name']) ?>">
          <?= htmlspecialchars((string)$cat['name']) ?>
        </option>
      <?php } ?>
    </select>
    </div>

    <div class="form-group">
      <button type="submit">Submit</button>
    </div>

  </form>
</section>
</body>
</html>
