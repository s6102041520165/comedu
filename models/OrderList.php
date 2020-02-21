<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_list".
 *
 * @property int $id
 * @property int $order_id
 * @property string $f_name
 * @property string $l_name
 * @property string $tel
 * @property string $diet_row
 * @property int $diet_col
 *
 * @property Orders $order
 */
class OrderList extends \yii\db\ActiveRecord
{
    public $cnt;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'diet_col'], 'integer'],
            [['f_name', 'l_name'], 'required'],
            [['f_name', 'l_name'], 'string', 'max' => 30],
            [['tel'], 'string', 'max' => 10],
            [['diet_row'], 'string', 'max' => 2],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'f_name' => 'F Name',
            'l_name' => 'L Name',
            'tel' => 'Tel',
            'diet_row' => 'Diet Row',
            'diet_col' => 'Diet Col',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }
}
