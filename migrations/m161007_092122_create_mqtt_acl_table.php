<?php

use yii\db\Migration;

/**
 * Handles the creation for table `mqtt_acl`.
 */
class m161007_092122_create_mqtt_acl_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('mqtt_acl', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'topic' => $this->string()->notNull()->defaultValue('#'),
            'rw' => $this->smallInteger(1)->notNull()->defaultValue(1)
        ]);

        $this->createIndex('idx-user_id_topic', 'mqtt_acl', ['user_id', 'topic'], true);

        $this->addForeignKey('fk-mqtt_acl-user_id', 'mqtt_acl', 'user_id', 'user', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-mqtt_acl-user_id', 'mqtt_acl');

        $this->dropTable('mqtt_acl');
    }
}
