<?php

use yii\db\Migration;

/**
 * Handles the creation of table `language`.
 */
class m161028_105921_create_language_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('language', [
            'id' => $this->string(3)->notNull(),
            'name' => $this->string(31)->notNull(),
            'position' => $this->smallInteger()->defaultValue(0),
            'enabled' => $this->boolean()->notNull()->defaultValue(1)
        ]);

        $this->addPrimaryKey('id', 'language', 'id');

        $this->batchInsert('language', ['id', 'name', 'position'], [
            ['en', 'English', 1],
            ['de', 'Deutsch', 2],
            ['es', 'Español', 3],
            ['fr', 'Français', 4],
            ['pt', 'Português', 5],
            ['it', 'Italiano', 6],
            ['pl', 'Польский', 7],
            ['ru', 'Русский', 8],
            ['ua', 'Украинский', 9],
            ['zh', '中文', 10], // Китайский
            ['ja', '日本語', 11], // Японский
            ['ko', '한국어', 12], // Корейский
            ['ar', 'العربية', 13] // Арабский
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('language');
    }
}
