<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Banks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banks-form" style='width:82%;float:left;'>

    <?php $form = ActiveForm::begin(); ?>

   

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>
	
	
	
	
	
	 <?= $form->field($model, 'tel')->textInput(['maxlength' => true])->label('Телефон') ?>

    <?= $form->field($model, 'state')->dropDownList([
    '1' => 'Активный',
    '0' => 'Отключен'
])->label('Состояние'); ?>
	<?= $form->field($model, 'image')->fileInput()->label('Изображение') ?>

   

  
<div style="clear:both;"></div>
<div class="alert alert-info" role="alert">
    <?= $form->field($model, 'pars')->dropDownList([
    '1' => 'Активный',
    '0' => 'Отключен'
])->label('Парсер');  ?>

    <?= $form->field($model, 'parsurl')->textInput(['maxlength' => true])->label('URL парсера') ?>

   <?= $form->field($model, 'parsfile')->dropDownList([
    'pars/parser1?id='.$model->id => 'banki.ru',
    'pars/parser2?id='.$model->id => 'mainfin.ru'
])->label('Выбор парсера') ?>  <div style="clear:both;"></div></div><hr/>

    <?= $form->field($model, 'lrate')->dropDownList(['1' => 'Есть', '0' => 'Нет'])->label('Льготный курс');  ?><hr/>
<div style="padding:0px 30px 0px; "><p>Сумма минимального заказа</p>
    <input class="form-control" id="minord" type="number" value="0"></input>
	
	<select class="form-control" id="ordcur"><? foreach ($cur as $c) {echo '<option>'.$c->namecode.'</option>';}?></select>
	<a id="addmin" class="btn btn-primary">Добавить</a> <a id="remmin" class="btn btn-danger">Отчистить</a>
</div>
    <?= $form->field($model, 'lratex')->textInput()->label('') ?>

    <?= $form->field($model, 'time')->hiddenInput(['value' =>time()])?>

   

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div style="float:right; width:18%; text-align:right;"><?= isset($model->icon) ? ( Html::img($model->icon,[
                    'alt'=>' ',
                    'style' => 'width:100%;padding:10px; '
	])) : ( Html::img($model->icon,[
                    'alt'=>' ',
                    'style' => 'display:none;'
	]))   ?>
	<br/><br/>
	<?php echo  Html::a('Курсы',['rates/index', 'id'=>$model->id]);?>
	<br/>
	<?php echo  Html::a('Офисы',['office', 'id'=>$model->id]);?>
	
	</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>


var result;
	result =$("#banks-lratex").val();
$("#addmin").click(function() {
if ($("#minord").val() != 0 && !result.includes(  $("#ordcur").val()  )  ) {
	
	result +=$("#ordcur").val()+"=>"+$("#minord").val()+",";
	$("#banks-lratex").val(result); }});

$("#remmin").click(function() {result ='';$("#banks-lratex").val(""); });


</script>