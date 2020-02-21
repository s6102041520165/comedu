<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Orders */
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
\yii\web\YiiAsset::register($this);
$this->title = "เช็คอิน : ".$modelOrder->id;

?>
<div class="orders-view">
    <h3>จำนวนที่นั่ง <span class="badge badge-success"><?=$guest?></span> ที่นั่ง</h3>
    <div class="col-lg-6 col-md-12 col-sm-12">
        <?php if($modelOrder!==NULL) : ?>
            <?= DetailView::widget([
                'model' => $modelOrder,
                'attributes' => [
                    'id',
                    'price',
                    'created_at:relativeTime',
                    'status',
                    'checkin'
                ],
            ]) ?>
        <?php endif; ?>
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12">
        <?php if($modelList!==NULL) : ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>โต๊ะ</th>
                        <th>ชื่อ - สกุล</th>
                        <th>เบอร์โทร</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($modelList as $key => $value) : ?>
                    <tr>
                        <td><?=$modelList[$key]->diet_row.$modelList[$key]->diet_col;?></td>
                        <td>
                            <?=$modelList[$key]->f_name;?> <?=$modelList[$key]->l_name?>
                        </td>
                        <td>
                            <?=$modelList[$key]->tel;?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
