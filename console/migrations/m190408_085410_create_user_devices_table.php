<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_devices}}`.
 */
class m190408_085410_create_user_devices_table extends Migration
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

        $this->createTable('{{%user_devices}}', [
            'uid' => $this->string(100)->notNull()->unique(),
            'user_id' => $this->integer()->notNull(),
            'firebase_token' => $this->string()->notNull(),
            'name' => $this->string(),
        ],$tableOptions);

        $this->createIndex(
            '{{%idx-user_devices}}',
            '{{%user_devices}}',
            ['user_id', 'firebase_token']
        );

        $this->addForeignKey(
            '{{%fk-user_devices-user_id}}',
            '{{%user_devices}}',
            'user_id',
            '{{%users}}',
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
        $this->dropTable('{{%user_devices}}');
    }
}
