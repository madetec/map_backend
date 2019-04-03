<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notifications}}`.
 */
class m190403_193807_create_notifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%notifications}}', [
            'id' => $this->primaryKey(),
            'type' => $this->integer()->notNull(),
            'from_id' => $this->integer(),
            'item_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%notifications}}');
    }
}
