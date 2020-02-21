<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\BankSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Banks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bank-index">

    <?php Pjax::begin(); ?>
    <div class="panel">
        <div class="panel-body">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>

            <p>
                <?= Html::a('เพิ่มธนาคาร', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
    </div>

    <div class="panel">
        <div class="panel-body">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'bank_number',
                    'name_account',
                    'bank',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>