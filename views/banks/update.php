<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Banks */

$this->title = 'Редактировать банк: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Банки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="banks-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'cur'=> $cur,
    ]) ?>

</div>
