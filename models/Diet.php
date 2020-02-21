<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "diet".
 *
 * @property string $diet_row
 * @property int $diet_col
 */
class Diet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'diet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['diet_row', 'diet_col'], 'required'],
            [['diet_col'], 'integer'],
            [['diet_row'], 'string', 'max' => 2],
            [['diet_row', 'diet_col'], 'unique', 'targetAttribute' => ['diet_row', 'diet_col']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'diet_row' => 'แถว',
            'diet_col' => 'หมายเลข',
        ];
    }
}
