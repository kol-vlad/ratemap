<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Banks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="off-form">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/smoothness/jquery-ui.css" />




<h3>Добавить отделение</h3>
<hr/>

   <?php  $form = ActiveForm::begin();  ?>

   
<?= $form->field($model, 'addfield1')->textInput(['maxlength' => true])->label('Название.') ?>
    <?= $form->field($model, 'addres')->textInput(['maxlength' => true])->label('Адрес') ?>

    <?= $form->field($model, 'tel')->textInput(['maxlength' => true])->label('Телефон') ?>
	<?= $form->field($model, 'lat')->textInput(['maxlength' => true])->label('Широта') ?>
	<?= $form->field($model, 'lon')->textInput(['maxlength' => true])->label('Долгота') ?>
	
	
	<?= $form->field($model, 'wclocks')->textInput(['maxlength' => true])->label('Часы работы')  ?>
	 
	 <? for($i = 0, $a = 0; $i < 48; $i++){
    $time.= '<option>'.date("H:i", strtotime("today + $a minutes")) . '</option>';
    $a += 30;}?>
	 <div style="padding:0px 30px 10px; width:100%"><b>Пт - Пн</b> <select  id="bb"><? echo $time; ?></select> До <select id="baf" ><?
    echo $time;?></select>
	<b style="margin-left:20px;">Сб</b> <select  id="sb" ><?
    echo $time;?></select> До <select id="saf" ><?
    echo $time;?></select>
	<b style="margin-left:20px;">Вс</b> Выходной <input id="sun" type="checkbox">
      </div>

   <?= $form->field($model, 'bank_id')->HiddenInput( ['value' =>$Bank_id] ,['maxlength' => true] ) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end();?>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@19.8.0/dist/css/suggestions.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@19.8.0/dist/js/jquery.suggestions.min.js"></script>

<script>
    $("#office-addres").suggestions({
        token: "f56273f65491201f8f398878343a8e88fc4c6cef",
        type: "ADDRESS",
        /* Вызывается, когда пользователь выбирает одну из подсказок */
        onSelect: function(suggestion) {
            console.log(suggestion);
			 $("#office-lat").val(suggestion.data.geo_lat);
			  $("#office-lon").val(suggestion.data.geo_lon);
        }
    });
	
	$("#bb").change(function() {
$('#office-wclocks').val("Пт-Пн " + $("#bb").val()+"-"+$("#baf").val()+"; Сб " +$("#sb").val()+"-"+$("#saf").val()+sun );  });
$("#baf").change(function() {
$('#office-wclocks').val("Пт-Пн " + $("#bb").val()+"-"+$("#baf").val()+"; Сб " +$("#sb").val()+"-"+$("#saf").val()+sun );  });
$("#sb").change(function() {
$('#office-wclocks').val("Пт-Пн " + $("#bb").val()+"-"+$("#baf").val()+"; Сб " +$("#sb").val()+"-"+$("#saf").val()+sun );  });
$("#saf").change(function() {
$('#office-wclocks').val("Пт-Пн " + $("#bb").val()+"-"+$("#baf").val()+"; Сб " +$("#sb").val()+"-"+$("#saf").val()+sun );  });
sun= '';
$("#sun").change(function() {
if($("#sun").prop("checked")) { 
sun= "; Вс Выходной";
$('#office-wclocks').val("Пт-Пн " + $("#bb").val()+"-"+$("#baf").val()+"; Сб " +$("#sb").val()+"-"+$("#saf").val()+sun );} else {sun= ";";
	$('#office-wclocks').val("Пт-Пн " + $("#bb").val()+"-"+$("#baf").val()+"; Сб " +$("#sb").val()+"-"+$("#saf").val()+sun );} });
</script>