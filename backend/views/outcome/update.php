<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Outcome $model */

$this->title = 'Update Outcome: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Outcomes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="outcome-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
