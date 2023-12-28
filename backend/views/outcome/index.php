<?php

use common\models\Outcome;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\OutcomeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Outcomes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outcome-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Outcome', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'product_id',
                'value' => function ($model) {
                    return $model->product->name;
                },
            ],
            [
                'attribute' => 'quantity',
                'value' => function ($model) {
                    return $model->quantity . ' dona';
                },
            ],
            [
                'attribute' => 'sum',
                'value' => function ($model) {
                    return Yii::$app->formatter->asInteger($model->sum) . ' so\'m';
                },
            ],

            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDate($model->created_at);
                },
            ],
            'outcome_group_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Outcome $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
