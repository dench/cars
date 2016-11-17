<?php

use yii\db\Migration;

/**
 * Handles adding robot_id to table `timeline`.
 */
class m161012_121727_add_robot_id_column_to_timeline_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('timeline', 'robot_id', $this->integer());

        $this->addForeignKey('fk-timeline-robot_id', 'timeline', 'robot_id', 'robot', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-timeline-robot_id', 'timeline');

        $this->dropColumn('timeline', 'robot_id');
    }
}
