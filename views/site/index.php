<?php




?>

<?php if($posts) : ?>
<div class="list-group">
    <?php foreach ($posts as $post) :  ?>
        <div class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <em class="text-primary"><?= $post['pub_date'] ?></em>
                <h4><?= $post['title'] ?></h4>
            </div>
            <a href="/web/site/post/<?= $post['p_id'] ?>" class="btn btn-primary">Read more...</a>

        </div>
    <?php endforeach; ?>
</div>
<?php else : ?>
<h2 class="text-muted">Posts not found</h2>
<?php endif;?>
