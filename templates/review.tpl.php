<?php

    declare( strict_types = 1);
    require_once(__DIR__ . '/../database/database.db.php');

    function drawReviewsForService(array $reviews) { 
        if (empty($reviews)) {
        
        }
        else{
        ?>

        
        <ul class="review-list">
            <h3> Reviews </h3>
            <?php foreach ($reviews as $review): ?>
                <li class="review-item">
                    <div class="review-header">
                        <div class="review-user">
                            <div class="avatar-placeholder"> <img src=<?=htmlspecialchars($review->userImg)?>> </div>
                            <div>
                                <div class="username"><?= htmlspecialchars($review->username) ?></div>
                                <div class="review-date"><?= htmlspecialchars($review->date) ?></div>
                            </div>
                        </div>
                        <div class="review-rating">
                            <?= str_repeat('★', (int) floor($review->rating)) ?>
                            <span class="rating-number">(<?= number_format($review->rating, 1) ?>)</span>
                        </div>
                    </div>
                    <p class="review-description">
                        <?= nl2br(htmlspecialchars($review->description)) ?>
                    </p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php }
    }


function drawReviewForm() { ?>
    <form class="review-form" method="POST" action="../actions/action_submit_review.php">
    <h2>Leave a Review</h2>
    <input type="hidden" name="service" value="<?= urlencode($_GET['id']) ?>">

    <label for="rating">Rating</label>
    <div class="star-rating">
        <input type="radio" id="star5" name="rating" value="5"><label for="star5">★</label>
        <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
        <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
        <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
        <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
    </div>

    <label for="description">Review</label>
    <textarea id="description" name="description" rows="5" required></textarea>

    <button type="submit">Submit Review</button>
    </form>



    <?php }
    
?>



