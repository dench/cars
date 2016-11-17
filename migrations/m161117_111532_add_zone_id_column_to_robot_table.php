<?php

use yii\db\Migration;

/**
 * Handles adding zone_id to table `robot`.
 */
class m161117_111532_add_zone_id_column_to_robot_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('robot', 'zone_id', $this->integer());

        $this->addForeignKey('fk-robot-zone_id', 'robot', 'zone_id', 'zone', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-robot-zone_id', 'robot');

        $this->dropColumn('robot', 'zone_id');
    }
}
