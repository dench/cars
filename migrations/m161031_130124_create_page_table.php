<?php

use yii\db\Migration;

/**
 * Handles the creation of table `page`.
 */
class m161031_130124_create_page_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('page', [
            'id' => $this->primaryKey(),
            'slug' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'enabled' => $this->boolean()->notNull()->defaultValue(1)
        ]);

        $this->createTable('page_lang', [
            'page_id' => $this->integer()->notNull(),
            'lang_id' => $this->string(3)->notNull(),
            'name' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'keywords' => $this->string()->notNull()->defaultValue(''),
            'description' => $this->text(),
            'text' => $this->text()
        ]);

        $this->addPrimaryKey('page_id-lang_id', 'page_lang', ['page_id', 'lang_id']);

        $this->addForeignKey('fk-page_lang-page_id', 'page_lang', 'page_id', 'page', 'id', 'CASCADE');

        $this->addForeignKey('fk-page_lang-lang_id', 'page_lang', 'lang_id', 'language', 'id', 'CASCADE', 'CASCADE');

        $this->insert('page', [
            'slug' => 'index',
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $this->batchInsert('page_lang', ['page_id', 'lang_id', 'name', 'title'], [
            [1, 'en', 'Home', 'Home'],
            [1, 'de', 'Home', 'Home'],
            [1, 'es', 'Home', 'Home'],
            [1, 'fr', 'Home', 'Home'],
            [1, 'pt', 'Home', 'Home'],
            [1, 'it', 'Home', 'Home'],
            [1, 'pl', 'Home', 'Home'],
            [1, 'ru', 'Home', 'Home'],
            [1, 'ua', 'Home', 'Home'],
            [1, 'zh', 'Home', 'Home'],
            [1, 'ja', 'Home', 'Home'],
            [1, 'ko', 'Home', 'Home'],
            [1, 'ar', 'Home', 'Home'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-page_lang-lang_id', 'page_lang');

        $this->dropForeignKey('fk-page_lang-page_id', 'page_lang');

        $this->dropTable('page_lang');

        $this->dropTable('page');
    }
}
