<?php

/** @var app\models\Users $users */

use yii\bootstrap5\ActiveForm;

?>

<h1>Accounts</h1>
<?php if(sizeof($users)) : ?>
<div class="list-group">
    <?php foreach($users as $user) : ?>
    <div class="list-group-item">
        <div class="row align-items-center">
            <div class="col">
                <h5><?= $user['username'] ?></h5>
                <em class="text-primary">Email: <?= $user['email'] ?></em>
            </div>
            <div class="col">
                <b>Role: <?= $user['role'] ?></b>
            </div>
            <div class="col text-end">
                <?php ActiveForm::begin(); ?>
                    <a href="/web/user/edit/<?= $user['u_id'] ?>" class="btn btn-success me-1">Edit</a>
                    <input type="hidden" name="u_id" value="<?= $user['u_id'] ?>">
                    <button class="btn btn-danger">Remove</button>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php else : ?>
    <h1 class="text-muted">No users</h1>
<?php endif; ?>
