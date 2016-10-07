<?php

use yii\db\Migration;

/**
 * Handles the creation for table `mqtt_acls`.
 */
class m161007_092122_create_mqtt_acls_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('mqtt_acls', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'topic' => $this->string()->notNull(),
            'rw' => $this->smallInteger(1)->notNull()
        ]);

        $this->addForeignKey('fk-mqtt_acls-user_id', 'mqtt_acls', 'user_id', 'user', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-mqtt_acls-user_id', 'mqtt_acls');

        $this->dropTable('mqtt_acls');
    }
}
