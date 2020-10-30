<?php
$categories = Session::get('categories');
$activeCategory = Session::get('activeCategory');
$categoryName = $categories[$activeCategory];
$search = isset($_GET['search']) ? $_GET['search'] : '';
// $index = array_search($activeCategory, );

?>

<div class="container">
    <h1 class="text-center mt-5">Category: <?= $categoryName ?></h1>
    <section>

        <!-- Search function -->
        <form id="search_php" method="GET" action="<?= URL ?>category/showCategory/<?= $activeCategory ?>">
            <div class="input-group mb-3">
                <input type="text" value="<?= $search ?>" class="form-control" name="search"
                       placeholder="Are you looking for a specific post?" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" id="button-addon2">Search</button>
                </div>
            </div>
        </form>
        <?php if(isset($this->posts)):?>
        <!-- Display all posts -->
        <div class="card-columns">
            <?php foreach ($this->posts as $item) :
                $planned = $item['published_date'] > date('Y-m-d H:i:s') ? ' planned' : '';
                $published = !$item['published'] ? ' not-published' : '';
                ?>
                <div class="card<?= $published.$planned?>">
                    <a href="<?= URL; ?>category/show/<?= $item['id']; ?>">
                        <img class="card-img-top" src="<?= URL . $item['image'] ?>" alt="Card image cap">
                    </a>
                    <div class="card-body">

                        <p class="card-text mb-0 text-muted"><small><?= $item['category_name'] ?></small></p>

                        <h5 class="card-title"><?= $item['header'] ?></h5>
                        <p class="card-text"><?= substr($item['content'], 0, 100) ?>
                            ...
                            <a href="<?= URL; ?>category/show/<?= $item['id']; ?>">read more</a>
                        </p>
                        <div class="row">
                            <div class="col">
                                <p class="card-text"><small class="text-muted"><?= $item['timestamp'] ?></small></p>
                            </div>

                            <div class="col">
                                <p class="card-text pull-right"><small class="text-muted">Posted by: </br><?= $item['firstname'] . ' ' . $item['lastname'] ?></small></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif;?>
    </section>