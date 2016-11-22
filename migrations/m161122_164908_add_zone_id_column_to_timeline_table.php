<?php

use yii\db\Migration;

/**
 * Handles adding zone_id to table `timeline`.
 */
class m161122_164908_add_zone_id_column_to_timeline_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('timeline', 'zone_id', $this->integer()->notNull());

        $this->addForeignKey('fk-timeline-zone_id', 'timeline', 'zone_id', 'zone', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-timeline-zone_id', 'timeline');

        $this->dropColumn('timeline', 'zone_id');
    }
}
