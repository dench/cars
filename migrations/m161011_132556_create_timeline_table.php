<?php

use yii\db\Migration;

/**
 * Handles the creation for table `timeline`.
 */
class m161011_132556_create_timeline_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('timeline', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'from' => $this->integer()->notNull(),
            'to' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('fk-timeline-user_id', 'timeline', 'user_id', 'user', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-timeline-user_id', 'timeline');

        $this->dropTable('timeline');
    }
}
