<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_card".
 *
 * @property int $detailID
 * @property double $amount
 * @property string $date_pay
 */
class TblCard extends \yii\db\ActiveRecord
{
    public $detailID;
    public $amount;
    public $date_pay;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detailID', 'amount', 'date_pay'], 'required'],
            [['detailID'], 'integer'],
            [['amount'], 'number'],
            [['date_pay'], 'safe'],
            [['detailID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'detailID' => 'Order I D',
            'amount' => 'Amount',
            'date_pay' => 'date_pay',
        ];
    }
}
