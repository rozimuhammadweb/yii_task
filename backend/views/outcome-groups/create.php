<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\OutcomeGroups $model */

$this->title = 'Create Outcome Groups';
$this->params['breadcrumbs'][] = ['label' => 'Outcome Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outcome-groups-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
