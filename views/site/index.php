<?php
	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use yii\helpers\Url;
	use yii\helpers\ArrayHelper;
	use yii\captcha\Captcha;
	/* @var $this yii\web\View */
	
	
	
	isset($cur2->keys) ? $this->title = $cur2->keys : $this->title = "Курсы валют в банках Москвы "; 
	$this->registerMetaTag([
    'name' => 'description',
    'content' => $cur2->description,
	]);$this->registerJsFile( '@web/js/https _cdnjs.cloudflare.com_ajax_libs_jquery_3.3.1_jquery.min.js', $options = ['position' => yii\web\View::POS_HEAD, ], $key = null );
	$this->registerJsFile( '@web/js/https _cdnjs.cloudflare.com_ajax_libs_jquery-modal_0.9.1_jquery.modal.min.js', $options = ['position' => yii\web\View::POS_HEAD, ], $key = null );
	$this->registerJsFile( '@web/js/jquery.animateNumber.min.js', $options = ['position' => yii\web\View::POS_HEAD, ], $key = null );
	$this->registerJsFile( '@web/js/jquery.animateNumber.js', $options = ['position' => yii\web\View::POS_HEAD, ], $key = null );
	
	
?>
<link rel="stylesheet" href="../css/font-awesome.min.css">
<link rel="stylesheet" href="../css/jquery.modal.min.css">
<div class="site-index">
	
	<?php  //Pjax::begin() ?>
	<div class="body-content" style="max-width:970px;margin: 0px auto 250px auto;">
		<?php $form = ActiveForm::begin(['action'=> Url::to(['site/showchange']),'options' => [
			
			'class' => 'form-horizontal',
			//'data-pjax' => true,
			],]); 
		?>
		<div class="jumbo">
			<h1>Курсы валют в банках Москвы <? if (isset ($cur2->name)) { echo '('.$cur2->name.')';} ?></h1>
		</div>
		<?  if ($send==true) { echo '
			<div class="alert alert-success" role="alert">
			Ваша заявка отправленна.
			</div>';
		} ?>
		<div style="float:left;"><h3>Отдать</h3>
			<div class="give"  >
				
				<?= $form->field($model, 'cashin')->textInput(['autofocus' => true])->label('') ?>
				<?php  if ($grid != true){ if (isset($cur2->code)) {$result =$cur2->code;} else 
				{$result = '840';}} else { $result ='';}?>
				<?= $form->field($model, 'incur')->dropDownList( \yii\helpers\ArrayHelper::map($cur, 'code', 'name'),[
					'options' => [
					$result =>['selected' => true],
					'643' => ['style' => 'font-weight:bold;']]
					
				])->label(''); ?></div></div>
				<div style="float:left;">
				<i id="change" class="fa  fa-refresh" aria-hidden="true"></i></div>
				
				<div style="float:left;"><h3>Получить</h3>
					<div class="give" >
						<?= $form->field($model, 'outcur')->dropDownList( \yii\helpers\ArrayHelper::map($cur, 'code', 'name'),[
							'options' => [
							isset($model->outcur)?$model->outcur:'643' => ['selected' => true],
							'643' => ['style' => 'font-weight:bold;'] 
							]
						])->label(''); ?>
						
						
					<?=	Html::submitButton('Показать', ['class' => 'btn btn-lg btn-success show']); ?> </div></div>
					
					
					<?php 
						
					ActiveForm::end(); ?>
	</div> 
</div> 

<?  if ($grid==true) { 
	echo GridView::widget([
	'dataProvider' => $dataProvider,
	'summary' => false,
	'rowOptions' => function ($model, $key, $index, $grid)
    {
		if($model->bank->state == false) {
			return ['style' => 'display:none;'];
		}
	},
	'columns' => [
	['attribute' => 'bank.name', 
	'label' =>'Банк',
	'format' => 'raw',
	'value' => function($dataProvider) {
		$return = Html::img(Url::to($dataProvider->bank->icon),[
		'alt'=>' ',
		'style' => 'width:35px;margin:5px;float:left;'
		]);
		$return .= $dataProvider->bank->name.'<br>';
		$return .=  Html::a('Отделения на карте',  ['site/map', 'id' =>$dataProvider->bank->id,], ['target' => '_blank','data-pjax'=>"0",'class' => ' ']) ;
		return $return;
	},
	
	],
	
	[
	'label' =>'Курс',
	'attribute' => 'sell',
	'format' => 'raw',
	'value' => function($dataProvider) use ($model) {
		
		$return = $dataProvider->ratex;
		$return .= '<br/>';
		$return .= \yii\helpers\Html::tag(
		'span',
		($dataProvider->bank->lrate == 1 and $model->cashin >= $dataProvider->lrate) ? 'Льготный': '',
		[
		'class' => 'label label-' . ( 'success' ),
		]
		);
		return $return;
	},
    ],
	
	
	['attribute' => 'bank.time',
	'label' =>'Дата, Время',
	'format' => 'raw',
	'value' => function($dataProvider)  {if ($dataProvider->bank->time == '') {$return = date("d.m.Y".' '."H:i",time() - 24518); return $return;}else { return $dataProvider->bank->time;}},
	],
	[
	'label' =>'Вы получаете',
	'attribute' => 'res', 
	'format' => 'raw',
	'value' => function($dataProvider) use ($modelcl, $model, $cur2) {
		
		
		$return = '<div style="float:left"><span class="lead">' . $dataProvider->res . '</span><br>';
		$return .= '<small>' . $dataProvider->cur_name . ' </small></div>';
		$arr = explode(',', $dataProvider->bank->lratex);
		foreach($arr as $str) {
			list($key, $value) = explode('=>', $str);
			$arr2[$key] = $value;
		}
		
		if ( ($model->cashin >= $arr2[$cur2->namecode]) and  ($arr2[$cur2->namecode]>1 ) ) {
			foreach ($dataProvider->offices as $office) {
			$office2[$dataProvider->bank->name.' ( '.$office->addres.' )'].= $office->addres;}
			$return .='<div id="ex'.$dataProvider->bank->id.'" style="width:350px;"  class="modal"><h3 style="margin-top:0px;">Заказаз валюты </h3><h4>'.$dataProvider->bank->name.'</h4>';
			$return .= Html::beginForm(['clients/add',], 'post', ['enctype' => 'multipart/form-data']);
			$return .='<br/><p>Имя</p>';
			$return .= Html::activeInput('text', $modelcl, 'name',['class'=>'form-control', 'required' => true]);
			$return .='<br/><p>Телефон</p>';
			$return .= Html::activeInput('text', $modelcl, 'tel',['class'=>'form-control','pattern'=> '7[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}','placeholder'=>'79001234567' , 'required' => true]);
			$return .='<br/><p>Выберите отделение</p>';
			$return .= Html::activeDropDownList( $modelcl, 'office', $office2,['class'=>'form-control'] );
			$return .='<br />';
			$return .= Html::activeHiddenInput($modelcl,'cash',['value' => $model->cashin.' '.$cur2->namecode ] );
			$return .= Html::activeHiddenInput($modelcl,'cashout',['value' => $dataProvider->res.' '.$dataProvider->cur_name] );
			$return .= Html::submitButton('Отправить', ['class' => 'btn btn-success']);
			$return .= Html::endForm();
			$return .= '<a href="#"  rel="modal:close"></a></br>
			</div>
		<div style="float:right;"><a class="btn btn-default" href="#ex'.$dataProvider->bank->id.'" rel="modal:open">Заказать</a></div>';}
		
		return $return;
	},
    ],
	]
    ]); 
	} else {  if (!isset ($cur2->text)) {?>
	
	<hr/>
	<div id="about" >
		
		<h2>О сервисе RateMap</h2>
		<p>RateMap - автоматизированный сервис мониторинга курсов валют банков Москвы с системой предзаказа.</p>
		<div class="abun">
			<img src="../uploads/s1.png"><br/>
			<b>Широкая зона покрытия</b>
			<p>С нами уже более 70 банков и география продолжит расширяться</p>
		</div>
		<div class="abun">
			<img src="../uploads/s2.png"><br/>
			<b>Без комиссий и скрытых платежей</b>
			<p>Наш сервис абсолютно бесплатный!</p>
		</div>
		<div class="abun">
			<img src="../uploads/s3.png"><br/>
			<b>Умный поиск</b>
			<p>Система учитывает льготные курсы банков</p>
		</div>
		<div class="abun">
			<img src="../uploads/s4.png"><br/>
			<b>Быстрый резерв</b>
			<p>В течение 20 мин Вы получите СМС с номером резерва</p>
		</div>
		<div class="abun">
			<img src="../uploads/s5.png"><br/>
			<b>Гарантия безопасности данных</b>
			<p>Весь обмен данными надежно зашифрован 128 битным ключом</p>
		</div>
		<div class="abun">
			<img src="../uploads/s6.png"><br/>
			<b>Круглосуточная поддержка пользователей</b>
			<p>Мы будем рады помочь вам в любое время дня и ночи</p>
		</div> 
	</div>
</div></div>
<div id="digits"  >
	<div class="cont">
		<div class="digun"><b id="bankI">0</b><br/>Банков в базе</div>
		<div class="digun"><b id="OffI">0</b><br/>Отделений</div>
		<div class="digun"><b id="OrdI">0</b><br/>Заказов обработано</div>
		<div class="digun"><b id="AppI">0</b><br/>Раз скачано приложение</div>
	</div>
</div>
<div id="callback"><div class="container">
	<h2>
		Обратная связь
	</h2>
	<?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
	
	<div class="alert alert-success">
		Thank you for contacting us. We will respond to you as soon as possible.
	</div>
	<?php elseif ($contact != ''): ?>
	<div class="row">
		<div class="col-lg-7">
			
			<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
			<?= $form->field($contact, 'name')->textInput()->label('Имя') ?>
			<?= $form->field($contact, 'email') ?>
			<?= $form->field($contact, 'body')->textarea(['rows' => 6])->label('Сообщение') ?>
			<?= $form->field($contact, 'verifyCode')->widget(Captcha::className(), [
				'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
			]) ?>
			<div class="form-group">
				<?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
			</div>
			
			<?php ActiveForm::end(); ?>
			
		</div>
	</div>
	<?php endif; ?>
</div> </div>
<? }}?>
<script>
	var show = true;
	var countbox = ".benefits__inner";
	$(window).on("scroll load resize", function () {
		if (!show) return false; 
		if($("#bankI").length>0) {
			var w_top = $(window).scrollTop(); 
			var e_top = $("#digits").offset().top; 
			var w_height = $(window).height(); 
			var d_height = $(document).height(); 
			var e_height = $("#digits").outerHeight(); 
			if (w_top + 800 >= e_top || w_height + w_top == d_height || e_height + e_top < w_height) {
				$("#bankI").animateNumber({ number: <? if (isset($banks)) { echo $banks+22; } else { echo'0' ;} ?> });
				$("#OffI").animateNumber({ number: <? if (isset($off)) { echo  $off+600;}else {echo  '0' ;} ?> });
				$("#OrdI").animateNumber({ number: <? if (isset($ords)) { echo $ords+158 ;}else { echo'0' ; } ?> });
				$("#AppI").animateNumber({ number: 196 });
				
				show = false;
			}}
	});
	$("#change")
	.click(function() {
		$("#change").addClass( "fa-spin" ).delay(500).queue(function () 
		{ $(this).removeClass('fa-spin'); 
			$(this).dequeue();
			var incur = $('#site-incur').val();
			$('#site-incur').val($('#site-outcur').val());
			$('#site-outcur').val(incur);
			
		}); });
		
		$("#site-incur").change(function() {
		$('#w0').attr('action', '/site/showchange?id='+ $("#site-incur").val());});
		$( document ).ready(function() {
		$('#w0').attr('action', $('#w0').attr('action')+'?id='+ $("#site-incur").val());});
		
		
		$(window).scroll(function() {
			if ($(this).scrollTop() > 180  && $(this).width() > 850) {
				$('#site-cashin').attr("placeholder", "Отдать");
				$('#site-cashin').css({ "position": "fixed", "top": "8px" , "z-index": "99999", "left": "calc(34% + 5px)"});
				$('#site-incur').css({ "position": "fixed", "top": "8px" , "z-index": "99999", "left": "calc(34% + 200px)"});
				$('#site-outcur').css({ "position": "fixed", "top": "8px" , "z-index": "99999", "left": "calc(34% + 445px)"});
				$('.show').css({ "position": "fixed", "top": "8px" , "z-index": "99999", "left": "calc(34% + 655px)", "margin-top": "0px"});
				$('.body-content i').css({ "position": "fixed", "top": "10px" , "z-index": "99999", "left": "calc(34% + 410px)", "margin": "0px 10px 0px 3px","font-size": "24px", });
				
				$('.nav').css({ "display": "none"});
				$('.give').css({ "border": "0px"});
				
				} else if ($(this).scrollTop() <= 180 && $(this).width() > 850) {
				$('#site-cashin').attr("placeholder", "");
				$('#site-cashin').css({ "position": "relative", "top": "0px" , "z-index": "99999", "left": "0px"});
				$('#site-incur').css({ "position": "relative", "top": "0px" , "z-index": "99999", "left": "0px"});
				$('#site-outcur').css({ "position": "relative", "top": "0px" , "z-index": "99999", "left": "0px"});
				$('.show').css({ "position": "relative", "top": "0px" , "z-index": "99999", "left": "0px","margin-top": "20px"});
				$('.nav').css({ "display": "block"});$('.give').css({ "border": "1px solid #2d7794"});
				$('.body-content i').css({ "position": "relative", "top": "0px" , "z-index": "99999", "left": "0px", "font-size": "45px","margin": "65px 25px 0px 25px"});
			}
		});
		
		$(document).ready(function(){
			$("li.scroll a").on("click", function(e){
				var anchor = $(this);
				
				$('html, body').stop().animate({
					scrollTop: $(anchor.attr('href').slice(1)).offset().top-50
				}, 777);
				e.preventDefault();
				return false;
			});
		});
		$(document).ready(function(){
			if ($("div").is("#w1")) {$('html, body').stop().animate({
					scrollTop: $('#w1').offset().top-80
				}, 777);}
		});
		
</script>
<?php if (isset ($cur2->text)) { ?>
	<div style= "background:#fff; padding:20px; font-style:20px;"> <?php
	echo Html::decode($cur2->text); ?></div> </div><? } ?>
		