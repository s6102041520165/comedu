<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Diet */

$this->title = 'Update Diet: ' . $model->diet_row;
$this->params['breadcrumbs'][] = ['label' => 'Diets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->diet_row, 'url' => ['view', 'diet_row' => $model->diet_row, 'diet_col' => $model->diet_col]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="diet-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
