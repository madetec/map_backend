<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cars}}`.
 */
class m190304_063920_create_cars_table extends Migration
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

        $this->createTable('{{%cars}}', [
            'id' => $this->primaryKey(),
            'model' => $this->string()->notNull(),
            'color_id' => $this->integer()->notNull(),
            'number' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-cars-user_id}}', '{{%cars}}', 'user_id');
        $this->addForeignKey(
            '{{%fk-cars-user_id}}',
            '{{%cars}}',
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cars}}');
    }
}
