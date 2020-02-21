<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bank".
 *
 * @property int $id
 * @property string $bank_number
 * @property string $name_account
 * @property string $bank
 */
class Bank extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bank';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bank_number', 'name_account', 'bank'], 'required'],
            [['bank_number'], 'string', 'max' => 10],
            [['name_account', 'bank'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'รหัส',
            'bank_number' => 'เลขบัญชี',
            'name_account' => 'ชื่อบัญชี',
            'bank' => 'ชื่อธนาคาร',
        ];
    }
}
