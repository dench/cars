<?php

use yii\db\Migration;

/**
 * Handles adding password to table `robot`.
 */
class m161205_172131_add_password_column_to_robot_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('robot', 'password', $this->string(32)->notNull()->defaultValue(''));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('robot', 'password');
    }
}
