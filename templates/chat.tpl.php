<?php

    
    declare( strict_types = 1);
    require_once(__DIR__ . '/../database/database.db.php');
    function drawChatBox($users, $firstchat){ ?>
        <div class="chat-container">
        <div class="user-list">
            <?php foreach ($users as $user): ?>
            <div class="user-item" data-user-id="<?= $user->id ?>">
                <img src="<?= $user->pfp?>" alt="UserImage" width=50> 
                <?= htmlspecialchars($user->username) ?>
                </a>
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
                <input type="hidden" name="receiverId" value="<?= $firstchat ?>">
                <input type="hidden" name="senderId" value="<?= $_SESSION['userId'] ?>">

                <textarea name="message" rows="1" placeholder="Type your message..."></textarea>
                <button type="submit">Send</button>
            </form>
        </div>
        </div>
    <?php }

?>
