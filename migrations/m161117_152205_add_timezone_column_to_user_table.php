<?php

use yii\db\Migration;

/**
 * Handles adding timezone to table `user`.
 */
class m161117_152205_add_timezone_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'timezone', $this->string()->notNull()->defaultValue('UTC'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'timezone');
    }
}
