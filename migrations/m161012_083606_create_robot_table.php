<?php

use yii\db\Migration;

/**
 * Handles the creation for table `robot`.
 */
class m161012_083606_create_robot_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('robot', [
            'id' => $this->primaryKey(),
            'mqtt_id' => $this->integer(),
            'name' => $this->string(20)->notNull(),
        ]);

        $this->addForeignKey('fk-robot-mqtt_id', 'robot', 'mqtt_id', 'mqtt_user', 'id', 'SET NULL');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-robot-mqtt_id', 'robot');

        $this->dropTable('robot');
    }
}
