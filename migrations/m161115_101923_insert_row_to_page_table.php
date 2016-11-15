<?php

use yii\db\Migration;

class m161115_101923_insert_row_to_page_table extends Migration
{
    public function up()
    {
        $this->insert('page', [
            'slug' => 'about',
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $id = Yii::$app->db->getLastInsertID();

        $this->batchInsert('page_lang', ['page_id', 'lang_id', 'name', 'title'], [
            [$id, 'en', 'About', 'About'],
            [$id, 'de', 'About', 'About'],
            [$id, 'es', 'About', 'About'],
            [$id, 'fr', 'About', 'About'],
            [$id, 'pt', 'About', 'About'],
            [$id, 'it', 'About', 'About'],
            [$id, 'pl', 'About', 'About'],
            [$id, 'ru', 'About', 'About'],
            [$id, 'ua', 'About', 'About'],
            [$id, 'zh', 'About', 'About'],
            [$id, 'ja', 'About', 'About'],
            [$id, 'ko', 'About', 'About'],
            [$id, 'ar', 'About', 'About'],
        ]);
    }

    public function down()
    {
        $this->delete('page', ['slug' => 'about']);
    }
}
