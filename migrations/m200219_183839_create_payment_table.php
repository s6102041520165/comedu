<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment}}`.
 */
class m200219_183839_create_payment_table extends Migration
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
        $this->createTable('{{%payment}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'f_name' => $this->string('30')->notNull(),
            'l_name' => $this->string('30')->notNull(),
            'date_pay' => $this->date(),
            'amount' => $this->float(7)->notNull(),
            'attach' => $this->string(100)->notNull()
        ], $tableOptions);

        // add foreign key for table `order`
        $this->addForeignKey(
            'fk-payment-order_id',
            'payment',
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
        $this->dropTable('{{%payment}}');
    }
}
