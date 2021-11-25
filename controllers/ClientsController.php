<?php
	
	namespace app\controllers;
	use Yii;
	use yii\filters\AccessControl;
	use yii\data\ActiveDataProvider;
	use yii\web\Controller;
	use app\models\Banks;
	use app\models\Status;
	use app\models\Clients;
	use app\controllers\SiteController;
	use app\controllers\iqsms_JsonGat;
	use app\models\Site;
	use app\models\Currency;
	
	class ClientsController extends \yii\web\Controller
	{
		
		public function behaviors()
		{
			return [
			
            
			];
		}
		
		
		public function actionUpdate($id)
		{
			$model = Clients::findOne($id);
			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				$status = Status::findOne('1');		
				$gate = new iqsms_JsonGate('z1570209044632', '277669');
				
				preg_match_all('/\((.*?)\)/', $model->office, $matches);
				$off = $matches[1][0];
				$text = str_replace('{name}', $model->name, $status[$model->status]); 
				$text = str_replace('{adr}', $off, $text); 
				$text = str_replace('{id}', $model->id, $text); 
				$messages = array(
				array(
				"clientId" => "1",
				"phone"=> $model->tel,
				"text"=> $text,
				"sender"=> "MediaGramma" 
				),
				
				);
				$sms = $gate->send($messages, 'lofto'); // отправляем пакет sms
				
				return $this->actionIndex($send=true);
			}
		}
		
		public function actionIndex($send=false)
		{
			if (Yii::$app->user->isGuest) {  return Yii::$app->response->redirect(['site/login']); } else {
				$status = Status::findOne('1');	 
				$query =  Clients::find();
				$dataProvider = new ActiveDataProvider([
				'query' => $query,
				]);
				
				if ($status->load(Yii::$app->request->post()) && $status->save()) {
				}
				
				return $this->render('index', [
				'dataProvider' => $dataProvider,'status' => $status, 'query' => $query, 'send' => $send,
				]);
			}}
			
		public function actionAdd()
			{   
				
				$model = new Clients();
				if ($model->load(Yii::$app->request->post()) ) {$model->save();
					$status = Status::findOne('1');		
					$gate = new iqsms_JsonGate('z1570209044632', '277669');
					$text = str_replace('{name}', $model->name, $status->new); 
					$text = str_replace('{id}', $model->id, $text); 
					$messages = array(
					array(
					"clientId" => "1",
					"phone"=> $model->tel,
					"text"=> $text,
					"sender"=> "MediaGramma" 
					),
					
					);
					$sms = $gate->send($messages, 'lofto'); // отправляем пакет sms
					
					$model = new Site();
					$cur = $model->findCurrency();
					return $this->render('//site/index',[ 'model' => $model, 'cur' => $cur, 'send' => true, 'sms'=>$sms,
					
					]);
				}
				
			}
			
	}
