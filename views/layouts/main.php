<?php
	
	/* @var $this \yii\web\View */
	/* @var $content string */
	
	use app\widgets\Alert;
	use yii\helpers\Html;
	use yii\bootstrap\Nav;
	use yii\bootstrap\NavBar;
	use yii\widgets\Breadcrumbs;
	use app\assets\AppAsset;
	use app\models\Currency;
	use app\widgets\Curmenu;
	AppAsset::register($this);
	
	if (class_exists('yii\debug\Module')) {
		$this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
	}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= Yii::$app->charset ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php $this->registerCsrfMetaTags() ?>
		<title><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
	</head>
	<body>
		<?php $this->beginBody() ?>
		
		<div class="wrap">
			<?php
				NavBar::begin([
				'brandLabel' => '<img style="width:150px;" src="../uploads/logo.png" class="pull-left"/>',
				'brandUrl' => Yii::$app->homeUrl,
				'brandOptions' => ['class' => 'logoa'],
				'options' => [
				'class' => 'navbar navbar-fixed-top',
				],
				]);
				echo Nav::widget([
				'options' => ['class' => 'navbar-nav navbar-right'],
				'items' => [
				['label' => 'О сервисе', 'url' => '\#about','options'=>[ 'class' => 'scroll']],
				['label' => 'Обратная связь', 'url' => '\#callback','options'=>[ 'class' => 'scroll']],
				
				!Yii::$app->user->isGuest ? ( 
				['label' => 'Банки', 'url' => ['banks/index']]) : (['label' => 'Banks', 'url' => ['banks/index'],'visible' => false]),
				
				!Yii::$app->user->isGuest ? ( 
				['label' => 'Валюты', 'url' => ['currency/index']]) : (['label' => 'Banks', 'url' => ['banks/index'],'visible' => false]),
				!Yii::$app->user->isGuest ? ( 
				['label' => 'Заказы', 'url' => ['clients/index']]) : (['label' => 'Banks', 'url' => ['banks/index'],'visible' => false]),
				
				Yii::$app->user->isGuest ? (
                ['label' => 'Войти', 'url' => ['/site/login']]
				) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
				'Выйти (' . Yii::$app->user->identity->username . ')',
				['class' => 'btn btn-default logout']
                )
                . Html::endForm()
                . '</li>'
				)
				],
				]);
				NavBar::end();
			?>
			
			<div class="container">
				<?= Breadcrumbs::widget([
					'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
				]) ?>
				<?= Alert::widget() ?>
				<?= $content ?>
				
			</div>
		</div>
		<footer class="footer">
			<div class="container">
				<p>Курсы валют:<?= Curmenu::widget() ?>         
				</p><br /><p class="pull-left">&copy; RateMap.ru <?= date('Y') ?></p>
			</div>
		</footer>
		<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage() ?>