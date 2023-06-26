<?php

/** @var controllers\SiteController $categories */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
?>

<h1 class="s-title">Categories page</h1>

<a href="/web/posts/category-add" class="btn btn-primary">Add category</a>

<hr>

<?php if($categories) : ?>
    <div class="list-group">
        <?php foreach ($categories as $category) : ?>
        <div class="list-group-item d-flex align-items-center">

                <h4><?= $category['c_title'] ?></h4>

            <div class="col text-end">
                <?php ActiveForm::begin(); ?>
                <a href="/web/posts/category-edit/<?= $category['c_id'] ?>" class="btn btn-success me-1">Edit</a>
                <input type="hidden" name="c_id" value="<?= $category['c_id'] ?>">
                <button class="btn btn-danger">Remove</button>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>


<?php else : ?>
    <h2 class="text-muted">No categories</h2>
<?php endif; ?>
