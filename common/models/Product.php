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
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 *
 * @property Category $category
 * @property Income[] $incomes
 * @property Outcome[] $outcomes
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['price'], 'number'],
            [['quantity', 'category_id'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nomi',
            'price' => 'Narxi',
            'quantity' => 'Soni',
            'category_id' => 'Kategoriyasi',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
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
