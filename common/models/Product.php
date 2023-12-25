<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property int|null $quantity
 * @property int|null $category_id
 *
 * @property Category $category
 * @property Income[] $incomes
 * @property Outcome[] $outcomes
 */
class Product extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'product';
    }

    public static function getProductPrice($productId)
    {
        $product = self::findOne($productId);
        return $product->price;
    }

    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['price'], 'number'],
            [['quantity', 'category_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'quantity' => 'Quantity',
            'category_id' => 'Category ID',
        ];
    }


    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }


    public function getIncomes()
    {
        return $this->hasMany(Income::class, ['product_id' => 'id']);
    }


    public function getOutcomes()
    {
        return $this->hasMany(Outcome::class, ['product_id' => 'id']);
    }
}
