<?php

/** @var \yii\web\View $this */

/** @var string $content */

use backend\assets\AppAsset;
use yii\bootstrap5\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div class="wrapper bg-ash">
        <?= \backend\widgets\Navbar::widget() ?>
        <div class="dashboard-page-one">
            <div class="sidebar-main sidebar-menu-one sidebar-expand-md sidebar-color">
                <?= \backend\widgets\Sidebar::widget() ?>
            </div>
            <div class="dashboard-content-one">
                <?= $content ?>
            </div>


        </div>
    </div>


    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
