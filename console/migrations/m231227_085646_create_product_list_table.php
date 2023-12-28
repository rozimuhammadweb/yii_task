<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_list}}`.
 */
class m231227_085646_create_product_list_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%product_list}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'quantity' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-product_list-product_id',
            '{{%product_list}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }


    public function safeDown()
    {
        $this->dropForeignKey('fk-product_list-product_id', '{{%product_list}}');
        $this->dropTable('{{%product_list}}');
    }
}
