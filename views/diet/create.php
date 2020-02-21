<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Diet */

$this->title = 'Create Diet';
$this->params['breadcrumbs'][] = ['label' => 'Diets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="diet-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
