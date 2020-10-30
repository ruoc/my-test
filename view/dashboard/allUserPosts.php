<?php include 'partial/sidebar.php'; ?>

<div class="col">
    <div class="container">
        <!-- Breadcrumbs-->
        <h2>Your Posts</h2>

        <!-- DataTables Example -->
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th colspan="3">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($this->allPosts)): ?>
                    <p>No post submitted yet</p>
                <?php else : ?>
                    <?php foreach ($this->allPosts as $post) : ?>
                        <tr>
                            <td><?= $post['header'] ?></td>
                            <td><?= $post['category_name'] ?></td>
                            <td><?php if($post['published']):?>Published<?php else:?>Un-published<?php endif;?></td>
                            <td><a href="<?= URL; ?>category/show/<?= $post['id']; ?>" class="btn btn-dark">View</a></td>
                            <td><a href="<?= URL; ?>dashboard/edit/<?= $post['id']; ?>" class="btn btn-primary">Edit</a>
                            </td>
                            <td><a href="<?= URL; ?>dashboard/delete/<?= $post['id']; ?>" class="btn btn-danger">Delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



                



    