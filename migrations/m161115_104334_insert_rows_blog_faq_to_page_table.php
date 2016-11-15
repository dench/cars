<?php

use yii\db\Migration;

class m161115_104334_insert_rows_blog_faq_to_page_table extends Migration
{
    public function up()
    {
        $this->insert('page', [
            'slug' => 'blog',
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $id = Yii::$app->db->getLastInsertID();

        $this->batchInsert('page_lang', ['page_id', 'lang_id', 'name', 'title'], [
            [$id, 'en', 'Blog', 'Blog'],
            [$id, 'de', 'Blog', 'Blog'],
            [$id, 'es', 'Blog', 'Blog'],
            [$id, 'fr', 'Blog', 'Blog'],
            [$id, 'pt', 'Blog', 'Blog'],
            [$id, 'it', 'Blog', 'Blog'],
            [$id, 'pl', 'Blog', 'Blog'],
            [$id, 'ru', 'Blog', 'Blog'],
            [$id, 'ua', 'Blog', 'Blog'],
            [$id, 'zh', 'Blog', 'Blog'],
            [$id, 'ja', 'Blog', 'Blog'],
            [$id, 'ko', 'Blog', 'Blog'],
            [$id, 'ar', 'Blog', 'Blog'],
        ]);

        $this->insert('page', [
            'slug' => 'faq',
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $id = Yii::$app->db->getLastInsertID();

        $this->batchInsert('page_lang', ['page_id', 'lang_id', 'name', 'title'], [
            [$id, 'en', 'Faq', 'Faq'],
            [$id, 'de', 'Faq', 'Faq'],
            [$id, 'es', 'Faq', 'Faq'],
            [$id, 'fr', 'Faq', 'Faq'],
            [$id, 'pt', 'Faq', 'Faq'],
            [$id, 'it', 'Faq', 'Faq'],
            [$id, 'pl', 'Faq', 'Faq'],
            [$id, 'ru', 'Faq', 'Faq'],
            [$id, 'ua', 'Faq', 'Faq'],
            [$id, 'zh', 'Faq', 'Faq'],
            [$id, 'ja', 'Faq', 'Faq'],
            [$id, 'ko', 'Faq', 'Faq'],
            [$id, 'ar', 'Faq', 'Faq'],
        ]);
    }

    public function down()
    {
        $this->delete('page', ['slug' => 'faq']);

        $this->delete('page', ['slug' => 'blog']);
    }
}
