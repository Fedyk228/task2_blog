<?php

/** @var controllers\SiteController $posts */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
?>

<h1 class="s-title">Posts page</h1>

<a href="/web/posts/add" class="btn btn-primary">Add post</a>

<hr>

<?php if($posts) : ?>
    <div class="list-group">
        <?php foreach ($posts as $post) : ?>
        <div class="list-group-item d-flex align-items-center">
            <div>
                <em class="text-primary"><?= $post['pub_date'] ?> </em>
                <?php if($post['username']) : ?>
                <b class="text-success"><?= $post['username'] ?></b>
                <?php endif; ?>

                <h4><?= $post['title'] ?></h4>
                <hr>
                <?php if($post['status'] == 1) : ?>
                <p class="text-warning">на рассмотрении</p>
                <?php elseif($post['status'] == 2) :?>
                <p class="text-danger">отклонено</p>
                <?php elseif($post['status'] == 3) : ?>
                <p class="text-success">опубликован</p>
                <?php endif; ?>
            </div>
            <div class="col text-end">
                <?php ActiveForm::begin(); ?>
                <a href="/web/posts/edit/<?= $post['p_id'] ?>" class="btn btn-success me-1">Edit</a>
                <input type="hidden" name="p_id" value="<?= $post['p_id'] ?>">
                <button class="btn btn-danger">Remove</button>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>


<?php else : ?>
    <h2 class="text-muted">No posts</h2>
<?php endif; ?>
