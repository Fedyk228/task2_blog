<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
?>
<a href="/web/user" class="btn btn-primary">Go back</a>

<h1 class="s-title">Comments page</h1>


<hr>

<?php if($comments) : ?>
    <div class="list-group">
        <?php foreach ($comments as $comment) : ?>
        <div class="list-group-item d-flex align-items-center">
            <div>
                <b><?= $comment['title'] ?></b>
                <p><?= $comment['comment_text'] ?></p>
            </div>
            <div class="col text-end">
                <?php ActiveForm::begin(); ?>
                <a href="/web/comments/edit/<?= $comment['comment_id'] ?>" class="btn btn-success me-1">Edit</a>
                <input type="hidden" name="comment_id" value="<?= $comment['comment_id'] ?>">
                <button class="btn btn-danger">Remove</button>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>


<?php else : ?>
    <h2 class="text-muted">No comments</h2>
<?php endif; ?>
