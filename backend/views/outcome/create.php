<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Create Outcome';
$this->params['breadcrumbs'][] = ['label' => 'Outcomes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="outcome-create mt-5">
    <?php $form = ActiveForm::begin(['action' => ['test'], 'options' => ['id' => 'addCart']]); ?>
    <div class="row">
        <div class="col-lg-3">
            <?= /** @var TYPE_NAME $products */
            $form->field($model, 'product_id')->widget(Select2::class, [
                'data' => ArrayHelper::map($products, 'id', 'name'),
                'options' => ['placeholder' => 'Maxsulotni tanlang...', 'id' => 'product-selector'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
                'pluginEvents' => [
                    'select2:select' => 'function(e) { getProductDetails(e.params.data.id); }',
                ],
            ]); ?>
        </div>
        <div class="col-lg-3">
            <?= $form->field($model, 'quantity')->textInput(['type' => 'number', 'min' => 1, 'id' => 'quantity-input']) ?>
        </div>

        <div class="form-group col-lg-2">
            <?= $form->field($model, 'price')->textInput(['type' => 'text', 'readonly' => true, 'id' => 'price-input']) ?>
        </div>

        <div class="form-group col-lg-2">
            <?= $form->field($model, 'total_sum')->textInput(['type' => 'text', 'readonly' => true, 'id' => 'total-sum-input']) ?>
        </div>
        <div class="form-group col-lg-2 mt-2">
            <?= Html::submitButton('Savatga qo\'shish', ['class' => 'btn btn-info py-4 px-5 mt-5', 'name' => 'submit-button', 'value' => 'add-to-list']) ?>
        </div>

        <div class="row">
            <h3>Tanlangan Mahsulotlar</h3>
            <div class="pt-5" id="selected-products-container">
                <?= /** @var TYPE_NAME $selectedProducts */
                $this->render('table', ['lists' => $selectedProducts]); ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

    <?php ActiveForm::begin(['action' => ['save-outcome'], 'options' => ['id' => 'save',]]); ?>
    <div class="form-group col-lg-2">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success py-3 px-5 mt-5', 'name' => 'save-button', 'value' => 'save']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php
$js = <<< JS
$('#product-selector').on('select2:select', function (e) {
    getProductDetails(e.params.data.id);
});

$('#quantity-input').on('input', function () {
    var productId = $('#product-selector').val();
    getProductDetails(productId);
});

$('#product-selector').on('select2:unselect', function (e) {
    $('#price-input').val('');
    $('#total-sum-input').val('');
});

//add card
$(document).on('submit', '#addCart', function (e) {
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
        url: url,
        type: 'POST',
        data: form.serialize(),
        success: function (data) {
            console.log(data);

            if (data.success) {
                $('#product-selector').val(null).trigger('change');
                $('#quantity-input').val('');

                if (data.hasOwnProperty('view')) {
                    updateSelectedProductsView(data.view);
                } else {
                    console.error('Error');
                }
            } else {
                console.error('Error:', data.message); 
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

// getprice
function getProductDetails(productId) {
    var quantity = $('#quantity-input').val();
    $.ajax({
        url: '/outcome/ajax-get-price',
        type: 'get',
        data: { productId: productId, quantity: quantity },
        success: function (result) {
            if (result.error) {
                console.error(result.error);
            } else {
                if (result.hasOwnProperty('price') && result.hasOwnProperty('totalSum')) {
                    $('#price-input').val(result.price);
                    $('#total-sum-input').val(result.totalSum);

                    var availableQuantity = result.availableQuantity;
                    if (quantity > availableQuantity) {
                        alert('Mahsulot soni yetarli emas. Maxsulot soni: ' + availableQuantity);
                    }
                } else {
                    console.error('Unexpected response:', result);
                }
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

// delete action
$(document).on('click', '.delete-product', function () {
    var productId = $(this).data('id');
    $.ajax({
        url: '/outcome/delete-product-list', 
        type: 'POST',
        data: { id: productId },
        success: function (data) {
            if (data.success) {
                updateSelectedProductsView(data.view);
            } else {
                console.error('Error delete:', data.message);
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});

//update
function updateSelectedProductsView(view) {
    $('#selected-products-container').innerHTML='';
    $('#selected-products-container').html(view);

}

JS;
$this->registerJs($js);
?>
