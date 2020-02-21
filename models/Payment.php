<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "payment".
 *
 * @property int $id
 * @property int $order_id
 * @property string $f_name
 * @property string $l_name
 * @property string $date_pay
 * @property double $amount
 * @property string $attach
 *
 * @property Orders $order
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $upload_foler;
    public static function tableName()
    {
        return 'payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id'], 'integer'],
            [['f_name', 'l_name', 'amount'], 'required'],
            [['date_pay'], 'safe'],
            [['amount'], 'number'],
            [['f_name', 'l_name'], 'string', 'max' => 30],
            [['attach'], 'string', 'max' => 100],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    public function upload($model, $attribute)
    {
        $photo  = UploadedFile::getInstance($model, $attribute);
        $path = $this->getUploadPath();
        if ($photo != null) {
            $fileName = "img/" . md5($photo->baseName . time()) . '.' . $photo->extension;
            if ($photo->saveAs($path . $fileName)) {
                return $fileName;
            }
        }
        return $model->isNewRecord ? false : $model->getOldAttribute($attribute);
    }

    public function getUploadPath()
    {
        return Yii::getAlias('@webroot') . '/' . $this->upload_foler . '/';
    }

    public function getUploadUrl()
    {
        return Yii::getAlias('@web') . '/' . $this->upload_foler . '/';
    }

    public function getPhotoViewer()
    {
        return empty($this->attach) ? Yii::getAlias('@web') . '/img/none.png' : $this->getUploadUrl() . $this->attach;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'รหัส',
            'order_id' => 'รหัสใบของ',
            'f_name' => 'ชื่อ',
            'l_name' => 'นามสกุล',
            'date_pay' => 'วันที่ชำระเงิน',
            'amount' => 'จำนวนเงิน',
            'attach' => 'ใบสลิป',
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
