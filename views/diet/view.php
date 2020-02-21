<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Diet */

$this->title = $model->diet_row;
$this->params['breadcrumbs'][] = ['label' => 'Diets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="diet-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'diet_row' => $model->diet_row, 'diet_col' => $model->diet_col], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'diet_row' => $model->diet_row, 'diet_col' => $model->diet_col], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'diet_row',
            'diet_col',
        ],
    ]) ?>

</div>
