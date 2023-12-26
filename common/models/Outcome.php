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
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Product $product
 */
class Outcome extends \yii\db\ActiveRecord
{
    public $product_price;
    public $product_count;
    public $total_sum;

    public static function tableName()
    {
        return 'outcome';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'outcome_group_id', 'quantity'], 'integer'],
            [['quantity', 'sum'], 'required'],
            [['sum'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'outcome_group_id' => 'Outcome Group ID',
            'quantity' => 'Quantity',
            'sum' => 'Sum',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
