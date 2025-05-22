<?php

    
    declare( strict_types = 1);
    require_once(__DIR__ . '/../database/database.db.php');
    function drawChatBox($users, $firstchat){ ?>
        <div class="chat-container">
        <div class="user-list">
            <?php foreach ($users as $user): ?>
            <div class="user-item" data-user-id="<?= $user['userId'] ?>" data-service-id="<?= $user['serviceId']?>" data-request-id="<?= $user['requestId']?>">
                <img src="<?= $user['profileP']?>" alt="UserImage" width=50> 
                <div class= "user-info">
                <?php if($user['clientId'] == $_SESSION['userId']) {?>
                    <p> Role: Artist </p>
                    <?php }
                    else {?>
                    <p> Role: Client </p>
                    <?php } ?>
                <p> User: <?= htmlspecialchars($user['username']) ?> </p>
                <p> Service: <?= htmlspecialchars($user['serviceName']) ?> </p>
                    </div>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="chat-box">
            <div id="messages">
            <?php foreach ($messages as $msg): ?>
                <div class="message <?= $msg['senderId'] == $_SESSION['userId'] ? 'sent' : 'received' ?>">
                <?= htmlspecialchars($msg['message']) ?><br>
                <small><?= $msg['timestamp'] ?></small>
                </div>
            <?php endforeach; ?>
            </div>

            <form id="chat-form" method="post" action="actions/action_send_message.php">
                <input type="hidden" name="receiverId" value="<?= $firstchat['userId'] ?>">
                <input type="hidden" name="senderId" value="<?= $_SESSION['userId'] ?>">
                <input type="hidden" name="serviceId" value="<?= $firstchat['serviceId'] ?>">
                <input type="hidden" name="requestId" value="<?= $firstchat['requestId'] ?>">


                <textarea name="message" rows="1" placeholder="Type your message..."></textarea>
                <button type="submit">Send</button>
            </form>
        </div>
        </div>
    <?php }

?>
