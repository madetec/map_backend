<?php

use yii\db\Migration;

/**
 * Handles the creation of table `phones`.
 */
class m190130_152747_create_phones_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%phones}}', [
            'id' => $this->primaryKey(),
            'sort' => $this->integer()->notNull(),
            'number' => $this->integer(9)->notNull(),
            'profile_id' => $this->integer()->notNull(),
        ],$tableOptions);

        $this->addForeignKey(
            '{{%fk-phones-profile_id}}',
            '{{%phones}}',
            'profile_id',
            '{{%profiles}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-phones-profile_id}}',
            '{{%phones}}',
            'profile_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%phones}}');
    }
}
