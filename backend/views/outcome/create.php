<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Outcome $model */

$this->title = 'Create Outcome';
$this->params['breadcrumbs'][] = ['label' => 'Outcomes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="outcome-create mt-5">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-lg-3">
                <?= $form->field($model, 'product_id')->widget(Select2::class, [
                    'data' => ArrayHelper::map($products, 'id', 'name'),
                    'options' => ['placeholder' => 'Select a product', 'id' => 'product-selector'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]); ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'product_count')->textInput(['type' => 'number', 'min' => 1]) ?>
            </div>

            <div class="col-lg-2">
                <?= $form->field($model, 'product_price')->textInput(['readonly' => true, 'id' => 'product-price']) ?>
            </div>

            <div class="col-lg-2">
                <?= $form->field($model, 'total_sum')->textInput(['readonly' => true, 'id' => 'outcome-total_sum']) ?>
            </div>

            <div class="form-group col-lg-2">
                <?= Html::submitButton('Savatga qo\'shish', ['class' => 'btn btn-primary py-3 px-5  mt-5', 'id' => 'add-to-list']) ?>
            </div>
            <div class="pt-5" id="selected-products">
                <h3>Tanlangan Mahsulotlar</h3>
                <table class="table table-bordered" id="selected-products-table">
                    <thead>
                    <tr>
                        <th>Nomi</th>
                        <th>Soni</th>
                        <th>Narxi</th>
                        <th>Ummumiy summa</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="selected-products-list"></tbody>
                </table>
                <hr>
                <div>
                    <strong>Tovarlar umumiy narxi:</strong>
                    <span id="overall-total-sum">0.00</span>
                </div>
                <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success py-3 px-5', 'id' => 'save-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>

<?php
$ajaxUrl = Yii::$app->urlManager->createUrl(['outcome/ajax-get-price']);

$js = <<<JS
    var selectedProducts = [];

    $('#product-selector').on('select2:select', function (e) {
        var productId = e.params.data.id;
        updateProductPrice(productId);
    });

    $('#add-to-list').on('click', function (e) {
        e.preventDefault();
        addToSelectedList();
    });

    $('#outcome-product_count').on('input', function () {
        updateTotalSum();
    });

    $('#save-button').on('click', function () {
    saveSelectedProducts();
});

    function updateProductPrice(productId) {
        $.ajax({
            url: '$ajaxUrl',
            method: 'GET',
            data: {productId: productId},
            success: function (data) {
                $('#product-price').val(data.price);
                $('#product-quantity').val(data.quantity);
                $('#outcome-product_count').val(1);
                updateTotalSum();
            },
            error: function (error) {
                console.error('Xatolik narx bilan:', error);
            }
        });
    }

    //ummumiy summani hisoblash | Mahsulot
    function updateTotalSum() {
        var productPrice = parseFloat($('#product-price').val()) || 0;
        var productCount = parseInt($('#outcome-product_count').val()) || 0;
        var totalSum = productPrice * productCount;
        $('#outcome-total_sum').val(totalSum.toFixed(2));
    }

function addToSelectedList() {
    var productName = $("#product-selector option:selected").text();
    var productCount = parseInt($('#outcome-product_count').val()) || 0;
    var productPrice = parseFloat($('#product-price').val()) || 0;
    var totalSum = productPrice * productCount;

    var tableRow = '<tr>' +
        '<td>' + productName + '</td>' +
        '<td>' + productCount + '</td>' +
        '<td>' + productPrice.toFixed(2) + '</td>' +
        '<td>' + totalSum.toFixed(2) + '</td>' +
        '<td><button class="btn btn-danger remove-button" aria-label="Close" onclick="removeProduct(this)"><span aria-hidden="true">&times;</span></button></td>' +
        '</tr>';

    $('#selected-products-table tbody').append(tableRow);

    // Umumiy summani o'zgarishini yangilash
    var overallTotalSum = parseFloat($('#overall-total-sum').text()) || 0;
    overallTotalSum += totalSum;
    $('#overall-total-sum').text(overallTotalSum.toFixed(2));

    // Tanlangan mahsulot ma'lumotlarini saqlash
    var selectedProduct = {
        name: productName,
        count: productCount,
        price: productPrice
    };
    selectedProducts.push(selectedProduct);

    saveToSession();

    // Listdan o'chirish
    $('#product-selector').val(null).trigger('change');
    $('#outcome-product_count').val('');
    $('#product-price').val('');
    $('#outcome-total_sum').val('');
}
function removeProduct(button) {
    var row = $(button).closest('tr');
    var index = row.index();
    var removedProduct = selectedProducts[index];
    var removedTotalSum = removedProduct.count * removedProduct.price;

    // Umumiy summani yangilash uchun
    var overallTotalSum = parseFloat($('#overall-total-sum').text()) || 0;
    overallTotalSum -= removedTotalSum;
    $('#overall-total-sum').text(overallTotalSum.toFixed(2));

    selectedProducts.splice(index, 1);
    row.remove();
    saveToSession();
}

function saveToSession() {
    $.ajax({
        url: 'OutcomeController/save-to-session',
        method: 'POST',
        data: {selectedProducts: JSON.stringify(selectedProducts)},
        success: function (response) {
            if (response.success) {
                console.log('success.');
            } else {
                console.error('Failed');
            }
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
}
   // remove btn uchun
    $('#selected-products-list').on('click', '.remove-button', function () {
        var index = $(this).closest('li').index();
        var removedProduct = selectedProducts[index];
        var removedTotalSum = removedProduct.count * removedProduct.price;

        // Umumiy summani yangilash uchun
        var overallTotalSum = parseFloat($('#overall-total-sum').text()) || 0;
        overallTotalSum -= removedTotalSum;
        $('#overall-total-sum').text(overallTotalSum.toFixed(2));

        selectedProducts.splice(index, 1);
        $(this).closest('li').remove();
    });
function saveSelectedProducts() {
    $.ajax({
        url: 'save-selected-products',
        method: 'POST',
        data: {selectedProducts: JSON.stringify(selectedProducts)},
        success: function (response) {
            if (response.success) {
                console.log('success');
            } else {
                console.error('Failed');
            }
        },
        error: function (error) {
            console.error('Error', error);
        }
    });
}
JS;
$this->registerJs($js);
?>