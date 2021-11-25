<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Currency */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="currency-form">

    <?php $form = ActiveForm::begin(); ?>
	<?= $form->field($model, 'state')->dropDownList([
    '1' => 'Включен',
    '0' => 'Отключен'
])->label('Состояние');  ?>

    <?= $form->field($model, 'code')->textInput()->label('Индекс валюты') ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название валюты') ?>

    <?= $form->field($model, 'namecode')->textInput(['maxlength' => true])->label('Код валюты') ?>

   <?= isset($model->icon) ? ( Html::img($model->icon,[
                    'alt'=>' ',
                    'style' => 'width:40px;'
	])) : ( Html::img($model->icon,[
                    'alt'=>' ',
                    'style' => 'display:none;'
	]))   ?>
	
	<?= $form->field($model, 'image')->fileInput()->label('Изображение') ?>
    
	
	
	 <?= $form->field($model, 'keys')->textInput(['maxlength' => true])->label('Тайтл') ?>
	 <?= $form->field($model, 'description')->textarea(['rows' => '6'])->label('Дескрипшн') ?>
	 <?= $form->field($model, 'text')->textarea(['rows' => '6'])->label('Текст') ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
