<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "outcome".
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $outcome_group_id
 * @property int $quantity
 * @property float $sum
 * @property string $date
 *
 * @property OutcomeGroups $outcomeGroup
 * @property Product $product
 */
class Outcome extends \yii\db\ActiveRecord
{

    public $total_sum;
    public $product_count;
    public $product_price;
    public $product_quantity;
    public static function tableName()
    {
        return 'outcome';
    }


    public function rules()
    {
        return [
            [['product_id', 'outcome_group_id', 'quantity'], 'integer'],
            [['quantity', 'sum', 'date'], 'required'],
            [['sum'], 'number'],
            [['date'], 'safe'],
            [['outcome_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => OutcomeGroups::class, 'targetAttribute' => ['outcome_group_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'outcome_group_id' => 'Outcome Group ID',
            'quantity' => 'Quantity',
            'sum' => 'Sum',
            'date' => 'Date',
        ];
    }
    public function getProductCount()
    {
        return $this->product_count;
    }

    public function setProductCount($value)
    {
        $this->product_count = $value;
    }

    public function getTotalSum()
    {
        return $this->total_sum;
    }

    public function setTotalSum($value)
    {
        $this->total_sum = $value;
    }


    public function getOutcomeGroup()
    {
        return $this->hasOne(OutcomeGroups::class, ['id' => 'outcome_group_id']);
    }


    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
?>
