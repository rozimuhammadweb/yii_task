<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Category;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var common\models\Outcome $model */
/** @var array $categories */
/** @var array $products */
?>

<div class="outcome-create">
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
            <?= $form->field($model, 'product_quantity')->textInput(['readonly' => true, 'id' => 'product-quantity']) ?>
        </div>

        <div class="col-lg-2">
            <?= $form->field($model, 'product_price')->textInput(['readonly' => true, 'id' => 'product-price']) ?>
        </div>

        <div class="col-lg-2">
            <?= $form->field($model, 'total_sum')->textInput(['readonly' => true, 'id' => 'outcome-total_sum']) ?>
        </div>

        <div class="form-group col-lg-2">
            <?= Html::submitButton('Savatga qo\'shish', ['class' => 'btn btn-primary mt-4', 'id' => 'add-to-list']) ?>
        </div>
        <div class="pt-5" id="selected-products">
            <h3>Tanlangan Mahsulotlar</h3>
            <ul id="selected-products-list"></ul>
            <hr>
            <div>
                <strong>Tovarlar ummumiy narxi:</strong>
                <span id="overall-total-sum">0.00</span>
            </div>
            <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success mt-1 px-5',]) ?>
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

    //Tanlanganlar ro'yhatiga qo'sish | Tanlanganlarni ummumiy summasi
    function addToSelectedList() {
        var productName = $("#product-selector option:selected").text();
        var productCount = $('#outcome-product_count').val();
        var productPrice = parseFloat($('#product-price').val()) || 0;
        var totalSum = productPrice * productCount;

       var listItem = '<li>' + productName + ' (Soni: ' + productCount + ', Narxi: ' + productPrice.toFixed(2) + ', Jami: ' + totalSum.toFixed(2) + ') <button class="btn btn-danger remove-button" aria-label="Close"><span aria-hidden="true">&times;</span></button></li>';
        $('#selected-products-list').append(listItem);
        
        //Umumiy summani o'zgarishini yangilash
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

        //listdan o'chirish
        $('#product-selector').val(null).trigger('change');
        $('#outcome-product_count').val('');
        $('#product-price').val('');
        $('#outcome-total_sum').val('');
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
        url: 'OutcomeController/save-selected-products', 
        method: 'POST',
        data: {selectedProducts: JSON.stringify(selectedProducts)},
        success: function (response) {
            if (response.success) {
                console.log('Selected products saved successfully.');
            } else {
                console.error('Failed to save selected products.');
            }
        },
        error: function (error) {
            console.error('Error saving selected products:', error);
        }
    });
}
JS;
$this->registerJs($js);
?>
