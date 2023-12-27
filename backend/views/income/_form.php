<?php

use common\models\Product;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Income $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="income-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-xl-3 col-lg-6 col-12 form-group">
            <?= $form->field($model, 'product_id')->widget(Select2::class, [
                'data' => ArrayHelper::map(Product::find()->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => 'Maxsulotni tanlang...',
                    'class' => 'form-control',
                    'style' => 'background-color: white;',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        </div>
        <div class="col-xl-3 col-lg-6 col-12 form-group">
            <?= $form->field($model, 'amount')->textInput(['type' => 'number', 'min' => 1]) ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success px-5 py-3']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
