<?php
declare(strict_types = 1);
require_once(__DIR__ . '/../database/database.db.php');

function drawMainHeader($categories) {
    ?>
    <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8"> 
            <link rel="stylesheet" href="../css/homestyle.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
            <link rel="stylesheet" href="../css/loginstyle.css">
            <link rel="stylesheet" href="../css/servicestyle.css">
            <link rel="stylesheet" href="../css/profilestyle.css">
            <link rel="stylesheet" href="../css/chatstyle.css">
            <link rel="stylesheet" href="../css/responsive.css">


        <script src="../javascript/artistMenu.js" defer></script>
        <script src="../javascript/payment-toggle.js" defer></script>
        <script src="../javascript/searchService.js" defer></script>
        <script src="../javascript/searchCategory.js" defer></script>
        <script src="../javascript/loadmessage.js" defer></script>

        <title>OnlineCanvas</title>
    </head>
    <body>
        <section id="main">
            <section id="header">
                <header>
                    <h1><a href="index.php"><strong>Online</strong><strong>Canvas</strong></a></h1>
                    <p>Discover. Create. Sell original artwork.</p>
                </header>

                <?php if (!isset($_SESSION['username'])): ?>
                    <h3><a href="login.php#login">Login</a></h3>
                    <h3><a href="become_artist.php">Become an Artist</a></h3>
                    <h3><a href="register.php#login">Register</a></h3>
                <?php else: ?>
                    <h3><a href="../actions/action_logout.php">Logout</a></h3>
                    <?php if (!isArtist($_SESSION['username'])): ?>
                        <h3><a href="become_artist.php">Become an Artist</a></h3>
                    <?php endif; ?>
                <?php endif; ?>
            </section>

            <?php if (!empty($categories)): ?>
            <section id="menu"> 
                <nav> 
                    <input type="checkbox" id="hamburger"> 
                    <label class="hamburger" for="hamburger">Categories</label>
                    <ul>
                        <?php foreach ($categories as $category): ?> 
                            <li>
                                <a href="category.php?c=<?= urlencode($category['name']) ?>">
                                    <?= htmlspecialchars($category['name']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>

                <a id="Search" href="searchService.php"><i class="fas fa-search"></i></a>

                <?php if (isset($_SESSION['username'])): ?>
                    <a id="Message" href="chat.php"><i class="fa-solid fa-envelope" ></i></a>

                    <?php if (isArtist($_SESSION['username'])): ?>
                        <a id="Artist" href="artistManage.php"><i class="fa-solid fa-clipboard-list" ></i></a>
                    <?php endif; ?>

                    <?php if (isAdmin($_SESSION['username'])): ?>
                        <a id="Admin" href="settings.php"><i class="fa-solid fa-gear"></i></a>
                    <?php endif; ?>

                    <a id="Profile" href="profile.php"><i class="fas fa-user" ></i></a>
                <?php else: ?>
                    <a id="Profile" href="login.php#login"><i class="fas fa-user" ></i></a>
                <?php endif; ?>
            </section>
            <?php endif; ?>
    <?php
}

function drawAdminPannel($nonAdmins = [],$stats = [], $stats7days) { ?>
         <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8"> 
            <link rel="stylesheet" href="../css/homestyle.css">
            <link rel="stylesheet" href="../css/responsive.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
            <link rel="stylesheet" href="../css/adminstyle.css">

            <title>Admin</title>
        </head>

        <body>
        <section class="admin-panel">
            <a href="index.php" class="back-arrow" title="Voltar à página inicial">
                 &#8592; 
            </a>
            <h2>🔧 Admin Control Panel</h2>

            <div class="admin-forms">
                <form class="promote-users-form" method="post" action="../actions/action_add_admin.php">
                        <input type="hidden" name="csrf" value=<?= $_SESSION['csrf']?>>
                        <h3>Promote Users to Admin</h3>
                        <div class="user-list-scroll">
                            <?php foreach ($nonAdmins as $user): ?>
                                <label class="user-item">
                                    <input type="checkbox" name="user_ids[]" value="<?= $user['id'] ?>">
                                    <img src="<?= $user['profileP'] ?>" alt="../profile_pictures/default.png">
                                    <?= htmlspecialchars($user['username']) ?> (<?= htmlspecialchars($user['email']) ?>)
                                </label>
                            <?php endforeach; ?>
                        </div>
                        <button type="submit">Promote Selected Users</button>
                    </form>
                <form class="add-category-form" method="post" action="../actions/action_add_category.php">
                    <input type="hidden" name="csrf" value=<?= $_SESSION['csrf']?>>
                    <h3>Add New Category</h3>
                    <label for="category_name">Category Name</label>
                    <input type="text" id="category_name" name="category_name" required>
                    <button type="submit">Add Category</button>
                </form>
            </div>
            <div class="statistics">
            <h3>📊 Site Statistics:</h3>
            <div class="stats-cards">
                <div class="stat-card">
                    <h4><?= $stats['artists'] ?></h4>
                    <p>Artists</p>
                </div>
                <div class="stat-card">
                    <h4><?= $stats['users'] ?></h4>
                    <p>Users</p>
                </div>
                <div class="stat-card">
                    <h4><?= $stats['services'] ?></h4>
                    <p>Services</p>
                </div>
            </div>
            <br>
             <h3> Last 7 days:</h3>
            <div class="stats-cards">
                <div class="stat-card">
                    <h4><?= $stats7days['reviews'] ?></h4>
                    <p>Total Reviews</p>
                </div>
                <div class="stat-card">
                    <h4><?= $stats7days['requests'] ?></h4>
                    <p>Total Requests</p>
                </div>
                <div class="stat-card">
                    <h4><?= $stats7days['messages'] ?></h4>
                    <p>Total Messages Sent</p>
                </div>
            </div>
        </div>

    <?php }

function drawArtistManagement() { ?>
    <div id="artistPannel">
        <div id="options">
            <button onclick="showSection('requests')">Requests</button>
            <button onclick="showSection('customRequests')">Custom Requests</button>
            <button onclick="showSection('services')">Your Services</button>
        </div>
        <div id="content"></div>
    </div> 
<?php }

function drawFooter() { ?>
        </section>
        <footer>
            <p>&copy; 2025 OnlineCanvas. All rights reserved.</p>
        </footer>
    </body>
    </html>
<?php }

function drawErrorLoginBox($error) { ?>
    <section class="errorBox">
        <h3>Not logged in</h3>
        <p><?= htmlspecialchars($error) ?></p>
        <a href="login.php">Login</a>
    </section>
<?php }

function drawErrorBox($error) { ?>
    <section class="errorBox">
        <p><?= htmlspecialchars($error) ?></p>
    </section>
<?php }
?>