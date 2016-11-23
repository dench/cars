<?php

use yii\db\Migration;

/**
 * Handles adding status to table `robot`.
 */
class m161123_112317_add_status_column_to_robot_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('robot', 'status', $this->smallInteger()->notNull()->defaultValue(1));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('robot', 'status');
    }
}
