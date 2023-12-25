<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%income}}`.
 */
class m231223_082050_create_income_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('income', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'amount' => $this->decimal(10, 2)->notNull(),
            'date' => $this->date()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-income-product_id',
            '{{%income}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-income-product_id', '{{%income}}');
        $this->dropTable('{{%income}}');
    }
}
