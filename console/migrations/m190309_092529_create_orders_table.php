<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m190309_092529_create_orders_table extends Migration
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

        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'status' => $this->integer(),
            'from_lat' => $this->float()->notNull(),
            'from_lng' => $this->float()->notNull(),
            'from_address' => $this->string()->notNull(),
            'to_lat' => $this->float()->null(),
            'to_lng' => $this->float()->null(),
            'to_address' => $this->string()->null(),
            'created_at' => $this->integer()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'completed_at' => $this->integer(),
            'driver_id' => $this->integer(),
        ], $tableOptions);

        $this->createIndex(
            '{{%idx-orders-driver_id-created_by}}',
            '{{%orders}}',
            ['driver_id', 'created_by']
        );

        $this->addForeignKey(
            '{{%fk-orders-driver_id}}',
            '{{%orders}}',
            'driver_id',
            '{{%users}}',
            'id'
        );

        $this->addForeignKey(
            '{{%fk-orders-created_by}}',
            '{{%orders}}',
            'created_by',
            '{{%users}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%orders}}');
    }
}
