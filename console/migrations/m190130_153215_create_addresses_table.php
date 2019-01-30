<?php

use yii\db\Migration;

/**
 * Handles the creation of table `addresses`.
 */
class m190130_153215_create_addresses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%addresses}}', [
            'id' => $this->primaryKey(),
            'sort' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'profile_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            '{{%fk-addresses-profile_id}}',
            '{{%addresses}}',
            'profile_id',
            '{{%profiles}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-addresses-profile_id}}',
            '{{%addresses}}',
            'profile_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('addresses');
    }
}
