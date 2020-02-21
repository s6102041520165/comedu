<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_list}}`.
 */
class m200219_185618_create_order_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%order_list}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'f_name' => $this->string(30)->notNull(),
            'l_name' => $this->string(30)->notNull(),
            'tel' => $this->string(10),
            'diet_row' => $this->string(2),
            'diet_col' => $this->integer()
        ], $tableOptions);

        // add foreign key for table `order`
        $this->addForeignKey(
            'fk-order_list-order_id',
            'order_list',
            'order_id',
            'orders',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_list}}');
    }
}
