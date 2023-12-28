<?php
$css = <<< CSS
.table td{
 text-align: center;
 vertical-align: center;
}
CSS;
$this->registerCss($css)

?>
<table class="table table-bordered table-warning" id="selected-products-table">
    <thead class="thead-dark">
    <tr>
        <th>id</th>
        <th>Soni</th>
        <th>Narxi</th>
        <th>Umumiy summasi</th>
        <th>O'chirish</th>
    </tr>
    </thead>
    <tbody id="selected-products-list">
    <?php use yii\helpers\Html;

    foreach ($lists as $list): ?>
        <tr>
            <td><?= $list->product->name ?></td>
            <td><?= $list->quantity ?> dona</td>
            <td><?= Yii::$app->formatter->asInteger($list->product->price) ?> so'm</td>
            <td><?= Yii::$app->formatter->asInteger($list->product->price * $list->quantity) ?> so'm</td>
            <td><a class="btn btn-danger delete-product" data-id="<?= $list->id ?>"> <i class="fa fa-times fa-2x"></i></a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<hr>
