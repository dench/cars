<?php

use yii\db\Migration;

/**
 * Handles the creation for table `page`.
 */
class m160704_151825_create_page extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('page', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'slug' => $this->string(100)->notNull()->unique(),
            'name' => $this->string()->notNull(),
            'title' => $this->string(),
            'description' => $this->string(),
            'keywords' => $this->string(),
            'text' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'enabled' => $this->boolean()->notNull()->defaultValue(true)
        ]);
        
        $this->addForeignKey('fk-page-user_id', 'page', 'user_id', 'user', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-page-user_id', 'page');
        
        $this->dropTable('page');
    }
}
