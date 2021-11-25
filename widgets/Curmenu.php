<?php
	namespace app\widgets;
	
	use Yii;
	use app\models\Currency;
	
	class Curmenu extends \yii\bootstrap\Widget
	{
		public function run()
		{
			Yii::$app->db->close();
			Yii::$app->db->open();
			$menu =  Currency::find()->where('State = :id', [':id' => '1'])->All();
			foreach ($menu as  $k => $item)
			{ if ($item->code !== 643 ){
			$output.= $k==0 ?  "<a href='/site/showchange?id=$item->code'>$item->name</a>" : " - <a href='/site/showchange?id=$item->code'>$item->name</a>";}}
			return $output;
		}
	}