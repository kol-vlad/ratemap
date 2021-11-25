<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Banks */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Банки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="banks-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           [ 'label'=> 'id','attribute'=>'id'],
		   [ 'label'=> 'Название банка','attribute'=>'name'],
		    [ 'label'=> 'Изображение','attribute'=>'icon'],
           [ 'label'=> 'Телефон','attribute'=>'tel'],
           [ 'label'=> 'Состояние','attribute'=>'state'],
           [ 'label'=> 'Парсер','attribute'=>'pars'],
           [ 'label'=> 'Источник','attribute'=>'parsurl'],
           [ 'label'=> 'Льготный курс','attribute'=>'lrate'],
		   [ 'label'=> 'Сумма мин. заказа','attribute'=>'lratex'],
            
          
            
        ],
    ]) ?>

</div>
