<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m231223_073359_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
            'quantity' =>$this->integer(11),
            'category_id' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'deleted_at' => $this->timestamp()->null(),
        ]);

        $this->addForeignKey(
            'fk-product-category_id',
            'product',
            'category_id',
            'category',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-products-category_id', 'product');
        $this->dropTable('product');
    }
}
