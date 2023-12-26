<?php

use common\models\Category;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form pt-5">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-12 form-group">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xl-3 col-lg-6 col-12 form-group">
            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xl-3 col-lg-6 col-12 form-group">
            <?= $form->field($model, 'quantity')->textInput() ?>
        </div>
        <div class="col-xl-3 col-lg-6 col-12 form-group">
            <?= $form->field($model, 'category_id')->widget(Select2::class, [
                'data' => ArrayHelper::map(Category::find()->all(), 'id', 'name'),
                'options' => [
                    'placeholder' => 'Select a category',
                    'class' => 'form-control',
                    'style' => 'background-color: white;',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>

        </div>

        <div class="form-group">
            <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success px-5 py-3']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
