<?php

use yii\db\Migration;

/**
 * Class m190305_132101_add_columns_addresses_table
 */
class m190305_132101_add_columns_addresses_table extends Migration
{

    public function safeUp()
    {
        $this->addColumn('{{%addresses}}', 'lat', $this->float()->null());
        $this->addColumn('{{%addresses}}', 'lng', $this->float()->null());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%addresses}}', 'lat');
        $this->dropColumn('{{%addresses}}', 'lng');
    }
}
