<?php
$data = $this->data;
$user = Session::get('user');
?>

<div class="container">
    <h1 class="text-center mt-5"><?= $data['header']; ?></h1>
    <div class="p-2 mb-3 text-center">
        Article published on <?= $data['published_date'] ?> in Category <a class="btn btn-light" href="<?= URL ?>category/showCategory/<?= $data['category_id'] ?>"><?= $data['category_name']; ?></a>
    </div>
    <div class="landscape-img">
        <img src="<?= URL ?><?= $data['image'] ?>" alt="">
    </div>
    <p class="mt-5"><?= $data['content']; ?></p>
</div>
