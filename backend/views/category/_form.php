<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Category $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xl-3 col-lg-6 col-12 form-group">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xl-3 col-lg-6 col-12 form-group">

            <?= $form->field($model, 'status')->widget(Select2::class, [
                'data' => [
                    '1' => 'Active',
                    '0' => 'Inactive',
                ],
                'options' => [
                    'placeholder' => 'Select Status',
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success ml-1 px-5 py-3']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
