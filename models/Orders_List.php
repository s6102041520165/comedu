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
 * @property string $status
 * @property string $timeBooking
 */
class orders_list extends \yii\db\ActiveRecord
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
            [['detailID','orderID', 'f_name', 'l_name', 'tel', 'diet_row', 'diet_col'], 'required'],
            [['detailID','orderID', 'diet_col'], 'integer'],
            [
                ['tel'],
                'string',
                'max' => 10,
                'min' => 10,
                'tooLong' => 'กรุณากรอกข้อมูลตัวเลข 10 ตัวอักษรค่ะ.',
                'tooShort' => 'กรุณากรอกข้อมูลตัวเลข 10 ตัวอักษรค่ะ.',
            ],
            [['f_name'], 'string', 'max' => 25],
            [['l_name'], 'string', 'max' => 25],
            [['diet_row'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'detailID' => 'รหัสการจอง',
            'orderID' => 'รหัสผู้จอง',
            'f_name' => 'ชื่อ',
            'l_name' => 'นามสกุล',
            'tel' => 'เบอร์โทร',
            'diet_row' => 'แถว',
            'diet_col' => 'โต๊ะ',
        ];
    }
}
