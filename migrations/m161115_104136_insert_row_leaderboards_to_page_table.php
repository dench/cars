<?php

use yii\db\Migration;

class m161115_104136_insert_row_leaderboards_to_page_table extends Migration
{
    public function up()
    {
        $this->insert('page', [
            'slug' => 'leaderboards',
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $id = Yii::$app->db->getLastInsertID();

        $this->batchInsert('page_lang', ['page_id', 'lang_id', 'name', 'title'], [
            [$id, 'en', 'Leaderboards', 'Leaderboards'],
            [$id, 'de', 'Leaderboards', 'Leaderboards'],
            [$id, 'es', 'Leaderboards', 'Leaderboards'],
            [$id, 'fr', 'Leaderboards', 'Leaderboards'],
            [$id, 'pt', 'Leaderboards', 'Leaderboards'],
            [$id, 'it', 'Leaderboards', 'Leaderboards'],
            [$id, 'pl', 'Leaderboards', 'Leaderboards'],
            [$id, 'ru', 'Leaderboards', 'Leaderboards'],
            [$id, 'ua', 'Leaderboards', 'Leaderboards'],
            [$id, 'zh', 'Leaderboards', 'Leaderboards'],
            [$id, 'ja', 'Leaderboards', 'Leaderboards'],
            [$id, 'ko', 'Leaderboards', 'Leaderboards'],
            [$id, 'ar', 'Leaderboards', 'Leaderboards'],
        ]);
    }

    public function down()
    {
        $this->delete('page', ['slug' => 'leaderboards']);
    }
}
