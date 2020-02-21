<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orders_list".
 *
 * @property int $detailID
 * @property int $orderID
 * @property string $f_name
 * @property string $l_name
 * @property string $tel
 * @property string $diet_row
 * @property int $diet_col
 */
class OrdersList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $cnt;
    public $counter;
    public static function tableName()
    {
        return 'orders_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orderID', 'diet_row', 'diet_col'], 'required'],
            [['orderID', 'diet_col'], 'integer'],
            [
                ['tel'],
                'string',
                'max' => 10,
                'tooLong' => 'กรุณากรอกข้อมูลตัวเลข 8 - 10 ตัวอักษรค่ะ.',
                'min' => 8,
                'tooShort' => 'กรุณากรอกข้อมูลตัวเลข 8 - 10 ตัวอักษรค่ะ.',
            ],
            [['f_name'], 'string', 'max' => 25 ,'message' => 'ป้อนข้อความไม่เกิน 25 ตัวอักษร'],
            [['l_name'], 'string', 'max' => 25 ,'message' => 'ป้อนข้อความไม่เกิน 25 ตัวอักษร'],
            [['diet_row'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'detailID' => 'รหัสรายละเอียด',
            'orderID' => 'รหัสการจอง',
            'f_name' => 'ชื่อ',
            'l_name' => 'นามสกุล',
            'tel' => 'ที่อยู่',
            'diet_row' => 'แถว',
            'diet_col' => 'โต๊ะ',
        ];
    }
}
