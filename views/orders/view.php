<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */

$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
\yii\web\YiiAsset::register($this);
$this->title = "ประวัติการจอง : " . $model->id;

?>
<div class="orders-view">
    <p>
        <?php if ($model->status == 0) : ?>
            <?= Html::a('อนุญาต', ['active', 'id' => $model->id], [
                'class' => 'btn btn-primary',
                'data' => [
                    'confirm' => 'ต้องการยืนยันประวัติการจองใช่หรือไม่?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>

        <?php if ($model->status == 1) : ?>
            <?= Html::a('ไม่อนุญาต', ['unactive', 'id' => $model->id], [
                'class' => 'btn btn-primary',
                'data' => [
                    'confirm' => 'ต้องการยกเลินประวัติการจองใช่หรือไม่?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>


        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'คุณต้องการลบประวัติการจองออกจากระบบหรือไม่?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <?php if ($model->status == 1) : ?>
                <h3>Qr Code สำหรับการเช็คอินภายในงาน</h3>
                <div class="alert alert-warning">กรุณาดาวน์โหลด Qr Code นี้ไว้เพื่อเช็คอินก่อนเข้างาน</div>
                <?= Html::a('ดาวน์โหลด', ['download', 'id' => $model->id], [
                    'class' => 'btn btn-success',
                    'data' => [
                        'confirm' => 'ต้องการดาวน์โหลด QR Code นี้ใช่หรือไม่',
                        'method' => 'post',
                    ],
                ]) ?>
                <div>
                    <img style="width:100%" src="<?= Yii::$app->request->BaseUrl . "/img/" . md5($model->id) . ".jpg"; ?>" alt="">
                </div>
            <?php endif; ?>
            <?php if ($model->status == 0) : ?>
                <div class="alert alert-danger">กำลังตรวจสอบข้อมูลของท่าน!</div>
            <?php endif; ?>
        </div>
        <div class="col-lg-8">
            <?php if ($model !== NULL) : ?>
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'price',
                        'created_at',
                    ],
                ]) ?>
            <?php endif; ?>
            <?php if ($modelPay !== NULL) : ?>
                <?= DetailView::widget([
                    'model' => $modelPay,
                    'attributes' => [
                        'f_name',
                        'l_name',
                        'amount',
                        [
                            'attribute' => 'attach',
                            'value' => '@web/' . $modelPay->attach, // WEB ACCESSABLE PATH + FILENAME 
                            'format' => ['image', ['width' => '400']],
                        ]
                    ],
                ]) ?>
            <?php endif; ?>

            <?php if ($OrderList !== NULL) : ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2" style="text-align:center">คุณและเพื่อน</th>
                        </tr>
                        <tr>
                            <th>โต๊ะ</th>
                            <th>ชื่อ - สกุล</th>
                            <th>เบอร์โทร</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($OrderList as $key => $value) : ?>
                            <tr>
                                <td><?= $OrderList[$key]->diet_row . $OrderList[$key]->diet_col; ?></td>
                                <td>
                                    <?= $OrderList[$key]->f_name; ?> <?= $OrderList[$key]->l_name ?>
                                </td>
                                <td>
                                    <?= $OrderList[$key]->tel; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

</div>