<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Html;
use app\controllers\UserController;
use app\controllers\PostsController;


AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

define('LOGIN', UserController::checkLogin());

$Categories = PostsController::getAllCategories();
$Tags = PostsController::getAllTags();

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <div class="container d-flex justify-content-between align-items-center">
        <a href="/web/site" class="header-logo">Blog Site</a>

        <nav>
            <?php if(LOGIN) : ?>
                <a href="/web/user/" class="me-4">Hello <?= LOGIN['username']; ?></a>
                <a href="/web/user/logout" class="me-4">Logout</a>
            <?php else : ?>
                <a href="/web/user/login" class="me-4">Login</a>
                <a href="/web/user/register">Register</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main>
    <div class="container d-flex">
        <div class="sidebar">

            <h2 class="list-title">Categories</h2>
            <div class="list">
                <a href="/web/site" class="list-item <?= !Yii::$app->request->get('category') ? 'list-item-active' : '' ?>">All categories</a>
                <?php if($Categories) :
                    foreach ($Categories as $category) :
                ?>
                    <a href="/web/site?category=<?= $category['c_id'] ?>" class="list-item <?= Yii::$app->request->get('category') == $category['c_id'] ? 'list-item-active' : '' ?>"><?= $category['c_title'] ?></a>
                <?php
                    endforeach;
                    endif;
                ?>
            </div>


            <h2 class="list-title">Tags</h2>
            <div class="tags">
                <?php if($Tags) :
                    foreach ($Tags as $tag) :
                        ?>
                        <a class="badge bg-secondary <?= Yii::$app->request->get('tag') == strtolower(trim($tag)) ? 'tag-active' : '' ?>" href="/web/site?tag=<?= strtolower(trim($tag)) ?>"><?= $tag ?></a>
                    <?php
                    endforeach;
                endif;
                ?>


            </div>


        </div>
        <div class="content">

            <?= $content; ?>

        </div>
    </div>

</main>

<footer>
    <div class="container text-center">
        <a href="#">Copyright &copy; <?= Date('Y'); ?></a>
    </div>
</footer>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
