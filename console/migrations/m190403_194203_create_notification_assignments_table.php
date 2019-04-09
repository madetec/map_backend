<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notification_assignments}}`.
 */
class m190403_194203_create_notification_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%notification_assignments}}', [
            'to_id' => $this->integer()->notNull(),
            'notification_id' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull()
        ]);

        $this->createIndex(
            '{{%idx-notification_assignments}}',
            '{{%notification_assignments}}',
            ['to_id', 'notification_id'],
            ['to_id', 'notification_id']
        );

        $this->addForeignKey(
            '{{%fk-notification_assignments-to_id}}',
            '{{%notification_assignments}}',
            'to_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE');

        $this->addForeignKey(
            '{{%fk-notification_assignments-notification_id}}',
            '{{%notification_assignments}}',
            'notification_id',
            '{{%notifications}}',
            'id',
            'CASCADE',
            'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%notification_assignments}}');
    }
}
