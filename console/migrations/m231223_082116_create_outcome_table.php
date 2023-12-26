<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%outcome}}`.
 */
class m231223_082116_create_outcome_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('outcome', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'outcome_group_id' => $this->integer(),
            'quantity' => $this->integer()->notNull(),
            'sum' => $this->decimal(10, 2)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            'deleted_at' => $this->timestamp()->null(),
        ]);

        $this->createIndex(
            'idx-outcome-product_id',
            'outcome',
            'product_id'
        );
        $this->addForeignKey(
            'fk-outcome-product_id',
            'outcome',
            'product_id',
            'product',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-outcome-product_id', 'outcome');
        $this->dropIndex('idx-outcome-product_id', 'outcome');
        $this->dropTable('outcome');
    }
}
