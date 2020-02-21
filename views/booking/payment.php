<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */
/* @var $form ActiveForm */
$this->title = 'แจ้งชำระเงิน';
?>
<div class="booking-payment">
    <div class="alert alert-success">หากไม่ทราบรหัสใบจอง หรือจำไม่ได้คุณสามารถดูรหัสใบจองที่เมนูบัตรเข้างานได้</div>
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>
        <?php if($orderShow->id!==NULL): ?>
        <?= $form->field($model, 'orderId')->textInput(['readonly' => true, 'value' => $orderShow->id]) ?>
        <?php endif; ?>


        <?php if($orderShow->id===NULL): ?>
        <?= $form->field($model, 'orderId') ?>
        <?php endif; ?>


        <?= $form->field($model, 'f_name') ?>
        <?= $form->field($model, 'l_name') ?>
        <?= $form->field($model, 'date_pay')->widget(
            DatePicker::className(), [
                'inline' => false, 
                //'template' => '<div class="well well-sm" style="background-color: #fff; width:100%">{input}</div>',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
        ]);?>
        <?= $form->field($model, 'amount') ?>
        <div class="well text-center col-lg-3">
          <?= Html::img($model->getPhotoViewer(),['style'=>'max-width:100%;','class'=>'img-rounded']); ?>
        </div>
        <div class="col-lg-9">
            <?= $form->field($model, 'attach')->fileInput() ?>
        </div>
        <div class="form-group" style="overflow:hidden;width:100%">
            <?= Html::submitButton('แจ้งชำระเงิน', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- booking-payment -->
