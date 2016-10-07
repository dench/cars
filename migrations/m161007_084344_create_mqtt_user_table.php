<?php

use yii\db\Migration;

/**
 * Handles the creation for table `mqtt_user`.
 */
class m161007_084344_create_mqtt_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('mqtt_user', [
            'id' => $this->integer()->notNull(),
            'pw' => $this->string(127)->notNull(),
            'super' => $this->boolean()->notNull()->defaultValue(0)
        ]);

        $this->addPrimaryKey('pk-mqtt_user-id', 'mqtt_user', 'id');

        $this->addForeignKey('fk-mqtt_user-id', 'mqtt_user', 'id', 'user', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-mqtt_user-id', 'mqtt_user');

        $this->dropTable('mqtt_user');
    }
}
