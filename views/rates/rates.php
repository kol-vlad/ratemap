<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BanksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $name;
$this->params['breadcrumbs'][] = ['label' => 'Банки', 'url' => ['banks/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banks-index">

    <h1><?= Html::encode($name) ?> (Курсы)</h1>
    <b> Парсер: <?= \yii\helpers\Html::tag(
                        'span',
                        $pars ? 'Вкл.' : 'Выкл.',
                        [
                            'class' => 'label label-' . ($pars ? 'success' : 'danger'),
                        ]
                    );?></b></br>
	<b> Льготный курс: <?= \yii\helpers\Html::tag(
                        'span',
                        $lrate ? 'Вкл.' : 'Выкл.',
                        [
                            'class' => 'label label-' . ($lrate ? 'success' : 'danger'),
                        ]
                    );?></b></br></br>
    


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
  <?php  ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'summary' => false,
		'beforeRow' => function ($model, $key, $index, $grid) {
	return Html::beginForm(['rates/update', 'id' => $model->id, 'bank_id' => $model->bank_id], 'post', ['enctype' => 'multipart/form-data']);},
	    'afterRow' => function ($model, $key, $index, $grid) {
	return Html::endForm();},
        'columns' => [
          
           
           
            
			['attribute' => 'cur_name', 'label' =>'Валюта',],
			
			['label' =>'Покупка','format' => 'raw',
			'value'=> !$pars ? ( function($model) {return 
			Html::activeInput('text', $model, 'buy');} ) : (function($model) {return 
			Html::activeInput('text', $model, 'buy');}) ,],
			
			
			[ 'label' =>'Продажа','format' => 'raw',
			'value'=> !$pars ? ( function($model) {return 
			Html::activeInput('text', $model, 'sell');} ) : (function($model) {return 
			Html::activeInput('text', $model, 'sell');}) ,],
			
			
			[ 'label' =>'Покупка (Л)','format' => 'raw',
			'value'=> !$lrate ? ( function($model) {return 
			Html::activeInput('text', $model, 'buy_l');} ) : ( function($model) {return 
			Html::activeInput('text', $model, 'buy_l');} ) ,],
			
			
			[ 'label' =>'Продажа (Л)','format' => 'raw',
			'value'=> !$lrate ? ( function($model) {return 
			Html::activeInput('text', $model, 'sell_l');} ) : (function($model) {return 
			Html::activeInput('text', $model, 'sell_l');}) ,],
			
			[ 'label' =>'Сумма льготного курса','format' => 'raw','visible' =>  $lrate,
			'value'=> function($model) {return 
			Html::activeInput('text', $model, 'lrate');} ,],
            
			[
                'attribute' => '',
				//'visible' =>  !$pars,
				'format' => 'raw',
                'value' => function($data)  {
                    return  Html::submitButton('Сохранить', ['class' => 'btn btn-success']);
                },
 
            ],
			 [
                'attribute' => '',
				 'format' => 'raw',
                'value' => function($data) use ($Bank_id) {
                    return  Html::a('Удалить',['ratedel', 'id'=>$data->id,'bank_id'=>$Bank_id ], ['class' => 'btn btn-danger']);
                },
 
            ],
            
        ],
		
    ]); ?>

<div class="form-group">

    </div>

<?php 

Print_r ($data);


?>



</div>
