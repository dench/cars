<?php

use yii\db\Migration;

/**
 * Handles adding zone to table `user`.
 */
class m161010_144220_add_zone_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'zone_id', $this->integer());

        $this->addForeignKey('fk-user-zone_id', 'user', 'zone_id', 'zone', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-user-zone_id', 'user');

        $this->dropColumn('user', 'zone_id');
    }
}
