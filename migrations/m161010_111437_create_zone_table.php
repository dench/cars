<?php

use yii\db\Migration;

/**
 * Handles the creation for table `zone`.
 */
class m161010_111437_create_zone_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('zone', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->notNull()->unique(),
            'user_id' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1)
        ]);

        $this->addForeignKey('fk-zone-user_id', 'zone', 'user_id', 'user', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-zone-user_id', 'zone');

        $this->dropTable('zone');
    }
}
