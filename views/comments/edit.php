<?php

/** @var controllers\SiteController $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

?>

<a href="/web/user" class="btn btn-primary">Go back</a>

<h1>Edit comment</h1>


<?php $form=  ActiveForm::begin(); ?>
<div class="py-1">
    <?= $form->field($model, 'comment_text')->textInput(); ?>
</div>

<div class="py-1">
    <button class="btn btn-success">Save comment</button>
</div>
<?php ActiveForm::end(); ?>

