<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
		'summary' => false,
        'columns' => [
					['attribute' => 'cur_name', 'label' =>'Валюта',],
					
					]
    ]); ?>