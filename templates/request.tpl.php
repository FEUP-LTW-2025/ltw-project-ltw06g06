<?php

    declare( strict_types = 1);
    require_once(__DIR__ . '/../database/database.db.php');
    require_once(__DIR__ . '/../database/request.class.php');




    function drawPendingRequests(array $requests) { ?>
        <div class="item_List">
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


    function drawArtistRequests(array $requests) { ?>
        <div class="item_List">
            <div class="item_header">
                <h2>Current Requests</h2>
                <a href= "artistManage.php?s=<?=urlencode((String)$_SESSION['userId'])?>"> See all your services </a>
            </div>
            <?php foreach ($requests as $request): ?>
                <form method="post" action="mark_complete.php" class="request">
                    <input type="hidden" name="service_id" value="<?= htmlspecialchars((String)$request->serviceId) ?>">
                    <input type="hidden" name="client_id" value="<?= htmlspecialchars((String)$request->clientId) ?>">

                    <p class="request-status">Status: <?= htmlspecialchars($request->status) ?></p>
                    <div class="request-details">
                        <img src="<?= htmlspecialchars($request->serviceImg) ?>" alt="Service Image">
                        <div class="request-info">
                            <h4><?= htmlspecialchars($request->serviceDescription) ?></h4>
                            <p>Category: <?= htmlspecialchars($request->category) ?></p>
                            <p>Date: <?= htmlspecialchars($request->date) ?></p>
                            <p>Client: <?= htmlspecialchars($request->clientName) ?></p>
                            <p>Description: <?= htmlspecialchars($request->request) ?></p>
                        </div>
                    </div>

                    <?php if ($request->status !== 'COMPLETE'): ?>
                        <button type="submit" name="mark_complete"> Done </button>
                    <?php else: ?>
                        <p class="completed-label">✅ </p>
                    <?php endif; ?>
                </form>
            <?php endforeach; ?>
        </div>
    <?php }


    function drawRequestForm() { ?>
       <form class="service-request-form" method="POST" action="actions/action_submit_request.php">
            <h2>Request This Service</h2>

            <input type="hidden" name="service" value="<?=urldecode($_GET['id'])?>">
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">


            <label for="description">Description of Request</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <fieldset>
                <legend>Select Payment Method</legend>
                <label><input type="radio" name="payment_method" value="credit" required> Credit Card</label>
                <label><input type="radio" name="payment_method" value="paypal"> PayPal</label>
                <label><input type="radio" name="payment_method" value="bank"> Bank Transfer</label>
            </fieldset>

            <div class="payment-method credit">
                <label>Card Number
                <input type="text" name="cc_number" placeholder="1234 5678 9012 3456">
                </label>
                <label>Expiry
                <input type="text" name="cc_expiry" placeholder="MM/YY">
                </label>
                <label>CVC
                <input type="text" name="cc_cvc" placeholder="123">
                </label>
            </div>

            <div class="payment-method paypal">
                <label>PayPal Email
                <input type="email" name="paypal_email" placeholder="email@example.com">
                </label>
            </div>

            <div class="payment-method bank">
                <label>IBAN
                <input type="text" name="iban" placeholder="DE00 0000 0000 0000 0000 00">
                </label>
            </div>

            <button type="submit">Send Request</button>
            </form>
    <?php }


function drawCustomRequestForm() { ?>
    <form class="custom-request-form" method="POST" action="actions/action_submit_custom_request.php">
        <h2>Request a Custom Service</h2>

        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        <label for="description">Description of Custom Service</label>
        <textarea id="description" name="description" rows="4" required></textarea>

        <button type="submit">Send Request</button>
    </form>
<?php
    }
    
?>
