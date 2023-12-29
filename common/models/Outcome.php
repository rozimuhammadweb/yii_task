<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

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
class Outcome extends ActiveRecord
{

    public $product_count;

    public static function tableName()
    {
        return 'outcome';
    }

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


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Nomi',
            'outcome_group_id' => 'Outcome Group ID',
            'quantity' => 'Miqdori',
            'sum' => 'Ummimiy summa',
            'created_at' => 'Yaratilgan',
            'updated_at' => 'Yangilangan',
            'deleted_at' => 'O\'chirilgan',
        ];
    }


    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }


}
