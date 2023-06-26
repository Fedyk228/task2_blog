<?php

/** @var controllers\SiteController $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

?>

<h1>Edit post</h1>

<a href="/web/posts" class="btn btn-primary">Go back</a>


<div class="row">
    <div class="col-sm-6 offset-3">
        <?php $form=  ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="py-1">
            <?= $form->field($model, 'title')->textInput(); ?>
        </div>
        <div class="py-1">
            <?= $form->field($model, 'text')->textarea(); ?>
        </div>
        <div class="py-1">
            <?= $form->field($model, 'category_id')->dropDownList($categories); ?>
        </div>
        <?php if($role == 'admin') : ?>
            <div class="py-1">
                <?= $form->field($model, 'status')->dropDownList([
                    '1' => 'на рассмотрении',
                    '2' => 'отклонено',
                    '3'=> 'опубликован'
                ]); ?>
            </div>
        <?php endif; ?>
        <?php if($model->picture) : ?>
        <div class="py-1">
            <img src="/web/upload/<?= $model->picture ?>" alt="" class="preview-min">
        </div>
        <?php endif; ?>
        <div class="py-1">
            <?= $form->field($model, 'picture')->fileInput(); ?>
        </div>
        <div class="py-1">
            <?= $form->field($model, 'tags')->textInput(); ?>
        </div>
        <div class="py-1">
            <button class="btn btn-success">Save post</button>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>