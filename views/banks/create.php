<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Banks */

$this->title = 'Создать банк';
$this->params['breadcrumbs'][] = ['label' => 'Банки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banks-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,'cur'=> $cur,
    ]) ?>

</div>
