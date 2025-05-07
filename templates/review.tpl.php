<?php

    declare( strict_types = 1);
    require_once(__DIR__ . '/../database/database.db.php');

    function drawReviewsForService(array $reviews) { ?>
        <ul class="review-list">
            <h3> Reviews </h3>
            <?php foreach ($reviews as $review): ?>
                <li class="review-item">
                    <div class="review-header">
                        <strong><?= htmlspecialchars($review->username) ?></strong>
                        <span class="review-date"><?= htmlspecialchars($review->date) ?></span>
                    </div>
                    <div class="review-rating">
                        Rating: <?= number_format($review->rating, 1) ?> / 5.0
                    </div>
                    <p class="review-description">
                        <?= nl2br(htmlspecialchars($review->description)) ?>
                    </p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php }
    


?>



