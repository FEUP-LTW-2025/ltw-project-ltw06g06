<?php

    declare( strict_types = 1);
    require_once(__DIR__ . '/../database/database.db.php');
    require_once(__DIR__ . '/../database/request.class.php');




    function drawPendingRequests(array $requests) { ?>
        <div class="request_List">
            <h2>Pending Requests</h2>
            <?php foreach ($requests as $request): ?>
                <div class="request">
                    <p class="request-status">Status: <?= htmlspecialchars($request->status) ?></p>
                    <div class="request-details">
                        <img src="<?= htmlspecialchars($request->serviceImg) ?>" alt="Service Image">
                        <div class="request-info">
                            <h4><?= htmlspecialchars($request->serviceDescription) ?></h4>
                            <p>Category: <?= htmlspecialchars($request->category) ?></p>
                            <p>Date: <?= htmlspecialchars($request->date) ?></p>
                            <p>Artist: <?= htmlspecialchars($request->artistName) ?></p>
                            <p>Description: <?= htmlspecialchars($request->request) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php }

?>
