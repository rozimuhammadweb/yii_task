<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Product $model */

$this->title = 'Maxsulot qo\'shish';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create mt-5">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
