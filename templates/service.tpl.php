<?php 

declare(strict_types = 1);
require_once(__DIR__ . '/../database/database.db.php');

function drawService($service, bool $owner = false) { ?>
    <section id="title">
        <h1><?= htmlspecialchars($service->name) ?></h1>
    </section>

    <section id="serviceDisplay">
        <img src="<?= htmlspecialchars($service->image) ?>" alt="Service Image" width="300">
        <h3><a href="artist.php?id=<?= urlencode((string)$service->artistId) ?>"><?= htmlspecialchars($service->artistName) ?></a></h3>
        
        <?php if ($owner): ?>
            <a id="edit" href="edit_service.php?id=<?= urlencode((string)$service->artistId) ?>">
                Edit Service <i class="fa fa-pencil" aria-hidden="true"></i>
            </a>
        <?php endif; ?>

        <div class="info">
            <h3>Description:</h3>
            <p><?= htmlspecialchars($service->description) ?></p>
            <p class="price"><?= htmlspecialchars((string)$service->cost) ?></p>
            <p class="rating"><?= htmlspecialchars((string)$service->rating) ?></p>
            <p class="waiting"> <?= htmlspecialchars((string)$service->avgTime) ?></p>
            <p class="requests">Times requested: <?= (int)$service->requests ?></p>
        </div>

         <?php if ($owner): ?>
            <a id="edit" href="edit_service.php?id=<?= urlencode((string)$service->artistId) ?>#scroll-form">
                Edit Service <i class="fa fa-pencil" aria-hidden="true"></i>
            </a>
        <?php endif; ?>

        <?php if (!$owner): ?>
        <form action="request.php#scroll-form" method="get" style="display:inline; margin: 0; padding: 0; border: none;">
            <input type="hidden" name="id" value="<?= htmlspecialchars((string)$service->id) ?>">
            <button type="submit">Request this service</button>
        </form>
        <?php endif; ?>


    </section>
<?php }

function drawServicesByCategory($services, string $category) { ?>
    <header id="popular_header">
        <h3><?= htmlspecialchars($category) ?> Services:</h3>
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input id="category" name="category" type="hidden" value="<?= htmlspecialchars($category) ?>">
            <input id="searchCategoryService" type="text" placeholder="Search for any service...">
        </div>
        Max. price: <input id="searchCategoryPrice" type="number" placeholder="Put max price here...">
        Min. rating: <input id="searchCategoryRating" type="number" min="0" max="5" step="0.1" placeholder="Put minimum rating here...">
    </header>

    <ul class="horizontal_popular_services">
        <?php if(empty($services)) { ?>
            <h3> No services found. </p>
        <?php } ?>
        <?php foreach ($services as $service): ?>
            <li class="service">
                <a class="serviceInfo" href="service.php?id=<?= urlencode((string)$service->id) ?>">
                    <h3><?= htmlspecialchars($service->name) ?></h3>
                    <img src="<?= htmlspecialchars($service->image) ?>" alt="Service Image" width="300" height="250">
                    <p><?= htmlspecialchars($service->artistName) ?></p>
                    <p><?= htmlspecialchars((string)$service->rating) ?></p>
                    <p><?= htmlspecialchars($service->category) ?></p>
                    <p><?= htmlspecialchars((string)$service->cost) ?></p>
                </a>
            </li>
        <?php endforeach; ?>
        </ul>
<?php }

function drawServices($services) { ?>
    <header id="popular_header">
        <h3>Services:</h3>
        <div class="search-container">
            <i class="fas fa-search search-icon"></i>
            <input id="searchservice" type="text" placeholder="Search for any service...">
        </div>
        Max. price: <input id="searchprice" type="number" placeholder="Max price">
        Min. rating: <input id="searchrating" type="number" min="0" max="5" step="0.1" placeholder="Min rating">
    </header>

    <ul class="horizontal_popular_services">
        <?php foreach ($services as $service): ?>
            <li class="service">
                <a class="serviceInfo" href="service.php?id=<?= urlencode((string)$service->id) ?>">
                    <h3><?= htmlspecialchars($service->name) ?></h3>
                    <img src="<?= htmlspecialchars($service->image) ?>" alt="Service Image" width="300" height="250">
                    <p><?= htmlspecialchars($service->artistName) ?></p>
                    <p><?= htmlspecialchars((string)$service->rating) ?></p>
                    <p><?= htmlspecialchars($service->category) ?></p>
                    <p><?= htmlspecialchars((string)$service->cost) ?></p>
                </a> 
        </li>
        <?php endforeach; ?>
    </ul>
<?php }


function drawServiceList($services, $aid) { ?>
    <div class="item_List">
        <div class="item_header">
            <h2>Artist Services:</h2>
            <a href="customService.php?id=<?= urlencode((string)$aid) ?>">Request a custom service</a>
        </div>

        <?php foreach ($services as $service): ?>
            <div class="service">
                <a href="service.php?id=<?= urlencode((string)$service->id) ?>">
                    <h3 class="service_title"><?= htmlspecialchars($service->name) ?></h3>
                    <div class="service_details">
                        <img src="<?= htmlspecialchars($service->image) ?>" alt="Service Image">
                        <div class="service-info">
                            <p>Description: <?= htmlspecialchars($service->description) ?></p>
                            <p>Category: <?= htmlspecialchars($service->category) ?></p>
                            <p class="rating">Rating: <?= htmlspecialchars((string)$service->rating) ?></p>
                            <p>Price: <?= htmlspecialchars((string)$service->cost) ?></p>
                            <p>Requests: <?= (int)$service->requests ?></p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php }

function drawPopularServices($services) { ?>
    <header id="popular_header"><h3>Popular Services</h3></header>
    <ul class="horizontal_popular_services">
        <?php foreach ($services as $service): ?>
               <li> <a class="serviceInfo" href="service.php?id=<?= urlencode((string)$service->id) ?>">
                    <h3><?= htmlspecialchars($service->name) ?></h3>
                    <img src="<?= htmlspecialchars($service->image) ?>" alt="Service Image" width="300" height="250">
                    <p><?= htmlspecialchars($service->artistName) ?></p>
                    <p><?= htmlspecialchars((string)$service->rating) ?></p>
                    <p><?= htmlspecialchars($service->category) ?></p>
                    <p><?= htmlspecialchars((string)$service->cost) ?></p>
                </a> </li>
        <?php endforeach; ?>
        </ul>
<?php }

function drawCustomServiceForm() { ?>
    <h2>Request a Custom Service</h2>
    <form id="scroll-form" class="custom_service_form" method="post" action="../actions/action_submit_custom_service.php" enctype="multipart/form-data">
        <input type="hidden" name="artistId" value="<?= htmlspecialchars((string)$_GET['id']) ?>">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars((string)$_SESSION['csrf']) ?>">

            <?php if (isset($_GET['error'])): ?>
                <div id="login-error" class="fade-message">
                     <p> <?= htmlspecialchars(urldecode($_GET['error'])) ?> </p>
                </div>
            <?php endif; ?>

        <label for="name">Service Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="5" required></textarea>

        <label for="image">Upload an Image:</label>
        <input type="file" id="image" name="image" accept="image/*">

        <label for="cost">Proposed Cost (€):</label>
        <input type="number" id="cost" name="cost" step="0.1" required>

        <button type="submit">Submit Service</button>
    </form>
<?php }

function drawCreateServiceForm($categories) { ?>
    <h2>Create a Service</h2>
    <form id="scroll-form" class="custom_service_form" method="post" action="../actions/action_submit_create_service.php" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars((string)$_SESSION['csrf']) ?>">
            <?php if (isset($_GET['error'])): ?>
                <div id="login-error" class="fade-message">
                     <p> <?= htmlspecialchars(urldecode($_GET['error'])) ?> </p>
                </div>
            <?php endif; ?>

        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="" disabled selected>Select a category</option>
            <?php foreach ($categories as $category): ?>
                <?php if (!empty($category['name'])): ?>
                    <option value="<?= htmlspecialchars((string)$category['name']) ?>">
                        <?= htmlspecialchars($category['name']) ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>

        <label for="name">Service Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="5" required></textarea>

        <label for="avgtime">Average Time (days):</label>
        <input type="number" id="avgtime" name="avgtime" step="0.1" required>

        <label for="image">Upload an Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required>

        <label for="cost">Proposed Cost (€):</label>
        <input type="number" id="cost" name="cost" step="0.1" required>

        <button type="submit">Submit Service</button>
    </form>
    <?php
}

function drawEditServiceForm($service) {?>
    <form action="../actions/action_edit_service.php" method="post" enctype="multipart/form-data" id="editServiceForm">
        <input type="hidden" name="id" value="<?= $service->id ?>">

        
       <?php if (isset($_GET['error'])): ?>
                <div id="login-error" class="fade-message">
                     <p> <?= htmlspecialchars(urldecode($_GET['error'])) ?> </p>
                </div>
        <?php endif; ?>

        <label for="name">Service Name:</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($service->name) ?>" required>

        
        <label for="image">Image:</label>
        <input type="file" id="image" name="image">

        
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required><?= htmlspecialchars($service->description) ?></textarea>

        <label for="cost">Cost (in $):</label>
        <input type="number" step="0.01" id="cost" name="cost" value="<?= htmlspecialchars((string) $service->cost) ?>" required>

        <label for="avgTime">Average Wait Time (in days):</label>
        <input type="number" id="avgTime" name="avgTime" value="<?= htmlspecialchars((string)$service->avgTime) ?>" required>



        <button type="submit">Save Changes</button>
    </form>
    <?php
}


?>