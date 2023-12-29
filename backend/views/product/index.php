<?php

use common\models\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var common\models\ProductSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Maxsulotlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index pt-4">
    <div class="row">
        <h3><?= Html::encode($this->title) ?></h3>
        <p>
            <?= Html::a('Qo\'shish', ['create'], ['class' => 'btn btn-success  px-5 py-3']) ?>
        </p>

        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'name',
                [
                    'attribute' => 'price',
                    'value' => function ($model) {
                        return Yii::$app->formatter->asInteger($model->price) . " so'm";
                    },
                ],
                [
                    'attribute' => 'quantity',
                    'value' => function ($model) {
                        return $model->quantity . " dona";
                    },
                ],
                [
                    'attribute' => 'category_id',
                    'value' => function ($model) {
                        return $model->category->name;
                    },
                ],
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Product $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    </div>
</div>
