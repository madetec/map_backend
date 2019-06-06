<?php

use yii\db\Migration;

/**
 * Class m190604_095347_add_columns_subdivisions_table
 */
class m190604_095347_add_columns_subdivisions_table extends Migration
{

    public function safeUp()
    {
        $this->addColumn('{{%subdivisions}}','lat', $this->float()->defaultValue(0)->null());
        $this->addColumn('{{%subdivisions}}','lng', $this->float()->defaultValue(0)->null());
        $this->addColumn('{{%subdivisions}}','address', $this->string()->null());
    }

    public function safeDown()
    {
        $this->dropColumn('{{%subdivisions}}','lat');
        $this->dropColumn('{{%subdivisions}}','lng');
        $this->dropColumn('{{%subdivisions}}','address');
    }
}
