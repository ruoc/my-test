<!-- Header -->
<!-- Here comes the main content -->
<div class="container"> <!-- START: div#content -->
<?php $currentDate = date('Y-m-d H:i:s');?>
    <!-- Content Cards -->
    <section>
        <div class="card-columns">
            <?php foreach ($this->post as $item) : 
                $planned = $item['published_date'] > $currentDate ? ' planned' : '';
                $published = !$item['published'] ? ' not-published' : '';
                ?>
                <div class="card d-none<?= $published.$planned?>">
                    <a href="<?= URL; ?>category/show/<?= $item['id']; ?>">
                        <?php if($item['image']):?>
                        <img class="card-img-top" src="<?= $item['image'] ?>" alt="Card image cap">
                        <?php else:?>
                        <img class="card-img-top" src="https://via.placeholder.com/400.png"/>
                        <?php endif;?>
                    </a>
                    <div class="card-body">
                        <p class="card-text mb-0 text-muted"><small><?= $item['category_name']?></small></p>
                        <h5 class="card-title"><?= $item['header'] ?></h5>
                        <p class="card-text"><?= substr($item['content'], 0, 100) ?>...<a
                                    href="<?= URL; ?>category/show/<?= $item['id']; ?>">read more</a></p>
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
        <!-- Pagination start -->
        <div class="mt-5">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center" id="cardPagination">

                </ul>
            </nav>
        </div>
    </section>
    <script>
        let activePage = <?= ACTIVE_PAGE ?>;
        let cardsPerPage = <?= CARDS_PER_PAGE ?>;
    </script>
    <script src="<?= URL . "public/js/pagination.js" ?>"></script>