<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\OutcomeGroups $model */

$this->title = 'Update Outcome Groups: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Outcome Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="outcome-groups-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
