<?php

use yii\db\Migration;

/**
 * Class m190606_103632_alter_columns_subdivisions_table
 */
class m190606_103632_alter_columns_subdivisions_table extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('{{%subdivisions}}', 'lat', $this->double(24)->null());
        $this->alterColumn('{{%subdivisions}}', 'lng', $this->double(24)->null());
        $this->alterColumn('{{%orders}}', 'from_lat', $this->double(24)->notNull());
        $this->alterColumn('{{%orders}}', 'from_lng', $this->double(24)->notNull());
        $this->alterColumn('{{%orders}}', 'to_lat', $this->double(24)->null());
        $this->alterColumn('{{%orders}}', 'to_lng', $this->double(24)->null());
    }

    public function safeDown()
    {
        $this->alterColumn('{{%orders}}', 'from_lat', $this->float()->notNull());
        $this->alterColumn('{{%orders}}', 'from_lng', $this->float()->notNull());
        $this->alterColumn('{{%orders}}', 'to_lat', $this->float()->null());
        $this->alterColumn('{{%orders}}', 'to_lng', $this->float()->null());
        $this->alterColumn('{{%subdivisions}}', 'lat', $this->float()->defaultValue(0)->null());
        $this->alterColumn('{{%subdivisions}}', 'lng', $this->float()->defaultValue(0)->null());
    }
}
