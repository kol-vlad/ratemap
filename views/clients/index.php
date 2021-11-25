<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CurrencySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-index">

    <h1><?= Html::encode($this->title) ?></h1>
<?  if ($send==true) { echo '
<div class="alert alert-success" role="alert">
 Статус обновлен.
</div>';
 } ?>
    

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           
			
			 [
                'attribute' => 'name',
				'label' =>'Имя',
				
 
            ],
			
            ['attribute' => 'tel', 'label' =>'Телефон',],
            
            ['attribute' => 'office', 'label' =>'Банк (отделение)',],
             
			  ['attribute' => 'cash', 'label' =>'Отдает',],
			   ['attribute' => 'cashout', 'label' =>'Получает',],
			   [
        'label' =>'Статус',
        'attribute' => 'status', 
        'format' => 'raw',
        'value' => function($dataProvider)use ( $model) {
	$return .= Html::beginForm(['clients/update', 'id' => $dataProvider->id], 'post', ['enctype' => 'multipart/form-data']);
 $return .= Html::activeDropDownList( $dataProvider, 'status', [
    'new' => 'Новый',
    'reserv' =>'Резерв',
    'can1'=>'Отменен 1',
	'can2'=>'Отменен 2',
	'done'=>'Готов',
],['class'=>'form-control'],['options' =>[$dataProvider->status => ['Selected' => true]]] );

 $return .= Html::submitButton('Обновить', ['class' => 'btn btn-success']);
 $return .= Html::endForm();
 
 
                return $return;
            },
    ],
            
        ],
    ]); 
	?>
	<h3>Статусы заказа</h3>
	<hr>
	 <? Pjax::begin(); $form = ActiveForm::begin(['action'=> Url::to(['clients/index']),'options' => [

 
 'data-pjax' => true,
 ],]);  ?>
	
	 <?= $form->field($status, 'new')->textarea(['rows' => '6'])->label('Новый') ?>
	 <?= $form->field($status, 'reserv')->textarea(['rows' => '6'])->label('Резерв') ?>
	 <?= $form->field($status, 'can1')->textarea(['rows' => '6'])->label('Отмена 1') ?>
	 <?= $form->field($status, 'can2')->textarea(['rows' => '6'])->label('Отмена 2') ?>
	 	 <?= $form->field($status, 'done')->textarea(['rows' => '6'])->label('Готов') ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); Pjax::end();?>

	
	
	
	
	
	

</div>
