<?php

use yii\db\Migration;

/**
 * Handles adding address to table `robot`.
 */
class m161128_140220_add_address_column_to_robot_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('robot', 'address', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('robot', 'address');
    }
}
