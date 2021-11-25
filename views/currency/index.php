<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CurrencySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Валюты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currency-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить валюту', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           
			
			 [
                'attribute' => 'name',
				'label' =>'Валюта',
				 'format' => 'raw',
                'value' => function($data){
                    return Html::a($data->name,['update', 'id'=>$data->id]);
                },
 
            ],
			
			
			
            [  
                'attribute' => 'state',
                'label'=>'Состояние',
                'format' => 'raw',
                'filter' => [
                    0 => 'Выкл.',
                    1 => 'Вкл.',
                ],'value' => function ($model, $key, $index, $column) {

                    $active = $model->{$column->attribute} === 1;
                    return \yii\helpers\Html::tag(
                        'span',
                        $active ? 'Вкл.' : 'Выкл.',
                        [
                            'class' => 'label label-' . ($active ? 'success' : 'danger'),
                        ]
                    );
                },
            ],
            ['attribute' => 'code', 'label' =>'Индекс валюты',],
            
            ['attribute' => 'namecode', 'label' =>'Код',],
             [
            'label' => 'Картинка',
            'format' => 'raw',
            'value' => function($data){
                return Html::img(Url::to($data->icon),[
                    'alt'=>' ',
                    'style' => 'width:40px;'
                ]);
            },
        ],

            ['class' => 'yii\grid\ActionColumn','template' => '{update} {delete}'],
        ],
    ]); ?>


</div>
