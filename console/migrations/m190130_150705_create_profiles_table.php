<?php

use yii\db\Migration;

/**
 * Handles the creation of table `profiles`.
 */
class m190130_150705_create_profiles_table extends Migration
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

        $this->createTable('{{%profiles}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'father_name' => $this->string(),
            'subdivision' => $this->string()->notNull(),
            'position' => $this->string()->notNull(),
            'main_phone_id' => $this->integer(),
            'main_address_id' => $this->integer(),
        ],$tableOptions);

        $this->addForeignKey(
            '{{%fk-profiles-user_id}}',
            '{{%profiles}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
        $this->createIndex(
            '{{%idx-profiles-user_id}}',
            '{{%profiles}}',
        'user_id',
            'user_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%profiles}}');
    }
}
