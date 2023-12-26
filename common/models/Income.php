<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "income".
 *
 * @property int $id
 * @property int|null $product_id
 * @property float $amount
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Product $product
 */
class Income extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'income';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id'], 'integer'],
            [['amount'], 'required'],
            [['amount'], 'number'],
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
            'amount' => 'Amount',
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
