<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%outcome_groups}}`.
 */
class m231223_082014_create_outcome_groups_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('outcome_groups', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('outcome_groups');
    }
}
