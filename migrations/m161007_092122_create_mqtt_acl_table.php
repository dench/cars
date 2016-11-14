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
            'mqtt_id' => $this->integer()->notNull(),
            'topic' => $this->string()->notNull()->defaultValue('#'),
            'rw' => $this->smallInteger(1)->notNull()->defaultValue(1)
        ]);

        $this->createIndex('udx-mqtt_id_topic', 'mqtt_acl', ['mqtt_id', 'topic'], true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('mqtt_acl');
    }
}
