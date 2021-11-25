<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BanksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Банки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banks-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить банк', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            [
                'attribute' => 'name',
				'label' =>'название',
				 'format' => 'raw',
                'value' => function($data){
                    return Html::a($data->name,['update', 'id'=>$data->id]);
                },
 
            ],
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
             [  
                'attribute' => 'state',
                'label'=>'Состояние',
                'format' => 'raw',
                'filter' => [
                    0 => 'Нет',
                    1 => 'Да',
                ],'value' => function ($model, $key, $index, $column) {

                    $active = $model->{$column->attribute} === 1;
                    return \yii\helpers\Html::tag(
                        'span',
                        $active ? 'Да' : 'Нет',
                        [
                            'class' => 'label label-' . ($active ? 'success' : 'danger'),
                        ]
                    );
                },
            ],
              [  
                'attribute' => 'pars',
                'label'=>'Парсер',
                'format' => 'raw',
                'filter' => [
                    0 => 'Нет',
                    1 => 'Да',
                ],'value' => function ($model, $key, $index, $column) {

                    $active = $model->{$column->attribute} === 1;
                    return \yii\helpers\Html::tag(
                        'span',
                        $active ? 'Да' : 'Нет',
                        [
                            'class' => 'label label-' . ($active ? 'success' : 'danger'),
                        ]
                    );
                },
            ],
            
            
          
            [  
                'attribute' => 'lrate',
                'label'=>'Льготный курс',
                'format' => 'raw',
                'filter' => [
                    0 => 'Нет',
                    1 => 'Да',
                ],'value' => function ($model, $key, $index, $column) {

                    $active = $model->{$column->attribute} === 1;
                    return \yii\helpers\Html::tag(
                        'span',
                        $active ? 'Да' : 'Нет',
                        [
                            'class' => 'label label-' . ($active ? 'success' : 'danger'),
                        ]
                    );
                },
            ],
           
       [
                'attribute' => 'Курсы',
				 'format' => 'raw',
                'value' => function($data){
                    return Html::a('Курс',['rates/index', 'id'=>$data->id]);
                },
 
            ],
            [
                'attribute' => 'Офисы',
				 'format' => 'raw',
                'value' => function($data){
                    return Html::a('Офисы',['office', 'id'=>$data->id]);
                },
 
            ],

            ['class' => 'yii\grid\ActionColumn','template' => '{update} {delete}'],
        ],
    ]); ?>


</div>
