<?php 

    declare( strict_types = 1);
    require_once(__DIR__ . '/../database/database.db.php');

    

    function drawService($service, bool $owner = false) {
        ?>
    
        <section id="title">
            <h1><?= $service->name ?></h1>
         </section>
         <section id="serviceDisplay">
                  <img src="<?= htmlspecialchars($service->image) ?>" alt="Service Image" width="300">
                  <h3> <a href="artist.php?id=<?= $service->artistId ?>"> <?= htmlspecialchars($service->artistName) ?> </a> </h3>
                  <?php if ($owner) { ?> <a id="edit" href="edit_service.php?id=<?= $service->artistId ?>"> Edit Service <i class="fa fa-pencil" aria-hidden="true"> </i> </a> <?php } ?>
                  <div class="info">
                    <h3> Description: </h3>
                    <p> <?= htmlspecialchars($service->name) ?></p>
                    <p> <?= htmlspecialchars($service->description) ?></p>
                    <p class="price"> <?= htmlspecialchars((string)$service->cost) ?></p>
                    <p class="rating"> <?= htmlspecialchars((string)$service->rating) ?> </p>
                    <p class="waiting"> <?= htmlspecialchars((string)$service->avgTime) ?> </p>
                    <p class="requests"> Times requested: <?= $service->requests ?> </p>
                  </div>
                  <a href="request.php?id=<?=$service->id?>"><button> Request this service </button></a>
        </section>
    <?php }

    function drawServicesByCategory($services,string $category) { ?>
        <header id="popular_header"><h3> <?= $category?> Services: </h3>
                <div class=search-container>
                <i class="fas fa-search search-icon"></i>
                <input id="category" name='category' type="hidden" value="<?= $category?>">
                <input id="searchCategoryService" type="text" placeholder="Search for any service...">
                </div>
                Max. price: <input id="searchCategoryPrice" type="number" placeholder="Put max price here...">
                Min. rating: <input id="searchCategoryRating" type="number" min="0" max="5" step="0.1" placeholder="Put minimum rating here...">
            </header>
                <section class="horizontal_popular_services">
                    <?php foreach($services as $service) { ?>
                    <li id="service"> <a class="serviceInfo" href="service.php?id=<?= $service->id?>">     
                        <h3><?= htmlspecialchars($service->name) ?> </h3>
                        <img src="<?= $service->image?>" alt="Service Image" width="300" height="250">
                        <p> <?= htmlspecialchars($service->artistName) ?> </p>
                        <p> <?= $service->rating ?> </p>
                        <p> <?= $service->category ?> </p>
                        <p> <?= $service->cost ?> </p>
                    </a>
                    </li>
                    <?php } ?>
                    </section>
    <?php 
    }

    function drawServices($services) { ?>
        <header id="popular_header"><h3> Services: </h3>
                <div class=search-container>
                <i class="fas fa-search search-icon"></i>
                <input id="searchservice" type="text" placeholder="Search for any service...">
                </div>
                Max. price: <input id="searchprice" type="number" placeholder="Max price">
                Min. rating: <input id="searchrating" type="number" min="0" max="5" step="0.1" placeholder="Min rating">
                </header>
                <section class="horizontal_popular_services">
                    <?php foreach($services as $service) { ?>
                    <li id="service"> <a class="serviceInfo" href="service.php?id=<?= $service->id?>">     
                        <h3><?= $service->name ?> </h3>
                        <img src="<?= $service->image?>" alt="Service Image" width="300" height="250">
                        <p> <?= $service->artistName ?> </p>
                        <p> <?= $service->rating ?> </p>
                        <p> <?= $service->category ?> </p>
                        <p> <?= $service->cost ?> </p>
                    </a>
                    </li>
                    <?php } ?>
                    </section>
    <?php 
    }

    function drawServiceList($services, $aid) { ?>
        <div class="item_List">
            <div class="item_header">
                <h2>Artist Services:</h2>
                <a href="customService.php?id=<?= urlencode($aid) ?>"> Request a custom service </a>
            </div>
            <?php foreach ($services as $service): ?>
                <div class="service">
                    <a href="service.php?id=<?= $service->id?>"><h3 class="service_title"> <?= htmlspecialchars($service->name) ?></h3>
                    <div class="service_details">
                        <img src="<?= htmlspecialchars($service->image) ?>" alt="Service Image">
                        <div class="service-info">
                            <h4><?= htmlspecialchars($service->description) ?></h4>
                            <p>Category: <?= htmlspecialchars($service->category) ?></p>
                            <p class="rating">Rating: <?= $service->rating ?></p>
                            <p>Price: <?= htmlspecialchars((String)$service->cost) ?></p>
                            <p>Requests: <?= $service->requests ?></p>
                        </div>
                    </div> </a>
                </div>

    <?php endforeach; ?>
        </div>
    <?php
    }

    function drawPopularServices($services) { ?>
        <header id="popular_header"><h3>Popular Services</h3></header>
                <section class="horizontal_popular_services">
                    <?php foreach($services as $service) { ?>
                    <li> <a class="serviceInfo" href="service.php?id=<?=urlencode((string)$service->id)?>">     
                        <h3><?= $service->name ?> </h3>
                        <img src="<?= htmlspecialchars($service->image)?>" alt="Service Image" width="300" height="250">
                        <p> <?= htmlspecialchars($service->artistName) ?> </p>
                        <p> <?= htmlspecialchars((string)$service->rating) ?> </p>
                        <p> <?= htmlspecialchars($service->category) ?> </p>
                        <p> <?= htmlspecialchars((string)$service->cost) ?> </p>
                    </a>
                    </li>
                    <?php } ?>
            </section>
    <?php }



    function drawCustomServiceForm(){ ?>
        <h2>Request a Custom Service</h2>
            <form class="custom_service_form" method="post" action="../actions/action_submit_custom_service.php" enctype="multipart/form-data">
                <input type="hidden" name="artistId" value="<?= htmlspecialchars($_GET['id']) ?>">
                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf']?>">
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

    <?php
    }


function drawCreateServiceForm($categories ) {

    ?>
    <h2>Create a Service</h2>
    <form class="custom_service_form" method="post" action="actions/action_submit_create_service.php" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">

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

        <label for="avgtime">Average Time(days):</label>
        <input type="text" id="avgtime" name="avgtime" required>

        <label for="image">Upload an Image:</label>
        <input type="file" id="image" name="image" accept="image/*">

        <label for="cost">Proposed Cost (€):</label>
        <input type="number" id="cost" name="cost" step="0.1" required>

        <button type="submit">Submit Service</button>
    </form>
    <?php
}




?>