<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%diet}}`.
 */
class m200219_172717_create_diet_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('diet', [
            'diet_row' => $this->string(2)->notNull(),
            'diet_col' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('news-diet_pk', 'diet', ['diet_row', 'diet_col']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%diet}}');
    }
}
