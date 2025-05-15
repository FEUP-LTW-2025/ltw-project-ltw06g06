<?php
    declare(strict_types = 1);
    require_once('database/database.db.php');
    require_once('database/user.class.php');
    require_once('database/artist.class.php');

    function drawProfile(User $user): void {?>
        <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8"> 
                <title>Profile</title>
            </head>
            <body>
                <header><h2 id="ProfileTitle" >Profile</h2></header>
                        <section id='profile'>
                        <div id="profileHeader">
                            <form action="edit_profile.php" method="get">
                                    <button type="submit" id="editProfileBtn">Edit Profile</button>
                            </form>
                        </div>

                        <img src="<?= $user->pfp ?>" alt="profile picture">

                        <div id='UserInfo'>
                            <p><strong>Name:</strong> <?= htmlspecialchars($user->name) ?></p>
                            <p><strong>Username:</strong> <?=  htmlspecialchars($user->username) ?></p>
                            <p><strong>Email:</strong> <?=  htmlspecialchars($user->email) ?></p>
                        </div>
                        </section>


            </body>
            </html>

    <?php }

        function drawArtistProfile(Artist $artist): void {?>
        <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8"> 
                <title>Artist Profile</title>
            </head>
            <body>
                <header><h2 id="ProfileTitle" >Artist Profile:</h2></header>
                        <section id='profile'>
                    
                        <img src="<?= $artist->pfp ?>" alt="profile picture">

                        <div id='UserInfo'>
                            <p><strong>Name:</strong> <?= htmlspecialchars($artist->name) ?></p>
                            <p><strong>Username:</strong> <?=  htmlspecialchars($artist->username) ?></p>
                            <p><strong>Email:</strong> <?=  htmlspecialchars($artist->email) ?></p>
                            <p><strong>Artist Description:</strong> <?=  htmlspecialchars($artist->description) ?></p>
                            <p><strong>Specialty:</strong> <?=  $artist->category ?></p>
                            <p class="rating"><strong>Rating:</strong> <?=  $artist->rating ?></p>
                            <p><strong>Number of Services:</strong> <?=  $artist->services ?></p>
                        </div>
                        </section>


            </body>
            </html>

    <?php }

?>