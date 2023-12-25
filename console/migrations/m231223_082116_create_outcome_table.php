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
            'date' => $this->date()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-outcome-product_id',
            'outcome',
            'product_id',
            'product',
            'id',
            'CASCADE',
            'CASCADE'
        );


        $this->addForeignKey(
            'fk-outcome-outcome_group_id',
            'outcome',
            'outcome_group_id',
            'outcome_groups',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-outcome-product_id', 'outcome');
        $this->dropForeignKey('fk-outcome-outcome_group_id', 'outcome');
        $this->dropTable('outcome');
    }
}
