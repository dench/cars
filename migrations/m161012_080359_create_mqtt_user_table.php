<?php

use yii\db\Migration;

/**
 * Handles the creation for table `mqtt_user`.
 */
class m161012_080359_create_mqtt_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('mqtt_user', [
            'id' => $this->primaryKey(),
            'pw' => $this->string(10)->notNull(),
            'super' => $this->boolean()->notNull()->defaultValue(false)
        ]);

        $this->addForeignKey('fk-user-mqtt_id', 'user', 'mqtt_id', 'mqtt_user', 'id', 'SET NULL');

        $this->addForeignKey('fk-mqtt_acl-mqtt_id', 'mqtt_acl', 'mqtt_id', 'mqtt_user', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-user-mqtt_id', 'user');

        $this->dropForeignKey('fk-mqtt_acl-mqtt_id', 'mqtt_acl');

        $this->dropTable('mqtt_user');
    }
}
