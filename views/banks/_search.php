<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BanksSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banks-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'icon') ?>

    <?= $form->field($model, 'tel') ?>

    <?= $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'pars') ?>

    <?php // echo $form->field($model, 'parsurl') ?>

    <?php // echo $form->field($model, 'parsfile') ?>

    <?php // echo $form->field($model, 'lrate') ?>

    <?php // echo $form->field($model, 'lratex') ?>

    <?php // echo $form->field($model, 'time') ?>

    <?php // echo $form->field($model, 'rates') ?>

    <?php // echo $form->field($model, 'office') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
