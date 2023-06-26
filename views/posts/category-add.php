<?php

/** @var controllers\SiteController $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

?>
<a href="/web/posts/categories" class="btn btn-primary">Go back</a>
<h1>Add category</h1>

<div class="row">
    <div class="col-sm-6 offset-3">
        <?php $form=  ActiveForm::begin(); ?>
        <div class="py-1">
            <?= $form->field($model, 'c_title')->textInput(); ?>
        </div>

        <div class="py-1">
            <button class="btn btn-success">Add category</button>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>