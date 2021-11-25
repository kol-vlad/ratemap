<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BanksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $name;
$this->params['breadcrumbs'][] = ['label' => 'Банки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banks-index">

    <h1><?= Html::encode($name) ?> (отделения)</h1>

    

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'summary' => false,
        'columns' => [
          
           ['attribute' => 'addfield1', 'label' =>'Название',],
           ['attribute' => 'addres', 'label' =>'Адрес',],
           ['attribute' => 'tel', 'label' =>'Телефон',],
		    ['attribute' => 'lat', 'label' =>'Широта',],
			 ['attribute' => 'lon', 'label' =>'Долгота',],
             ['attribute' => 'wclocks', 'label' =>'Часы работы',],
			
			
           [
                'attribute' => '',
				 'format' => 'raw',
                'value' => function($data) use ($Bank_id) {
                    return  Html::a('Удалить',['officedel', 'id'=>$data->id,'bank_id'=>$Bank_id ], ['class' => 'btn btn-danger']);
                },
 
            ],

            
        ],
    ]); ?>

<?= $this->render('_form2', [
        'model' => $model,
		'Bank_id' => $Bank_id,
    ]) ?>



</div>
