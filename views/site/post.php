<?php

use yii\bootstrap5\ActiveForm;

?>

<a href="/web/site" class="btn btn-primary">Go back</a>
    <hr>
<?php if($post) : ?>
<em class="text-success"><?= $post['pub_date'] ?></em>
<h1><?= $post['title'] ?></h1>

<?php if($post['picture']) : ?>
        <img src="/web/upload/<?= $post['picture']; ?>" class="preview" alt="">
<?php endif; ?>    


<p><?= $post['text'] ?></p>

<p><b>Author: <?= $post['username'] ?> </b></p>

    <hr>

<h3>Comments</h3>
    <?php
        if($login) :
    $form=  ActiveForm::begin(); ?>
    <div class="py-1">
        <?= $form->field($model, 'comment_text')->textInput(); ?>
    </div>
    <div class="py-1">
        <button class="btn btn-success">Add comment</button>
    </div>
    <?php ActiveForm::end();
        endif;
    ?>
    <hr>

<?php if($comments) : ?>
<div class="list-group mt-3">

    <?php foreach ($comments as $comment) : ?>
    <div class="list-group-item">
        <h5><?= $comment['username']; ?></h5>
        <p><?= $comment['comment_text']; ?></p>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>




<?php else : ?>
<h2 class="text-muted">Post not found</h2>

<?php endif; ?>