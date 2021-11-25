<?php

namespace app\controllers;
use Yii;
use app\models\Banks;

use app\models\Currency;
use app\models\Rates;
use GuzzleHttp\Client; 
use yii\helpers\Url;

class ParsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $pk='index';
        return $this->render('index', ['news' => $pq]);
    }
	
	public function actionInit()
    {   
	
	     $banks = Banks::find()->All();
		 foreach ($banks as $key => $bank)
		 { 
		 
		    if ($bank->pars == 1) {
			 file_get_contents("https://ratemap.ru/$bank->parsfile");sleep (2);
			 $pq .= $key.') '.$bank->name.' ok <br/>';
		 }}
		 
        
        return $this->render('index', ['news' => $pq]);
    }
	
	
	
    public function actionParser1 ($id) { 
	    
		
	
	//создаем таблицу курсов (если её нет) по объекту валют
	$currens = $this->findCurrency();
	
	foreach ($currens as $ccode) {
    if (!Rates::find()->Where('Bank_id = :id', [':id' => $id])->andWhere ('cur_code= :id2', [':id2' => $ccode->code])->All()) {
	    $modelbr = new Rates();
		$modelbr->cur_code = $ccode->code;
		$modelbr->cur_name = $ccode->namecode;
		$modelbr->bank_id = $id;
        $modelbr->save(); }
			}
	
	    $bank = Banks::findOne($id);
		
		if ($bank->pars) {
		$client = new Client();
        $res = $client->request('GET', $bank->parsurl);
        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);
        
		$table = $document->find("section[data-test='exchange-office-rates']");
		foreach ($currens as $cur) {
		
		if (!Rates::find()->Where('Bank_id = :id', [':id' => $id])->andWhere ('cur_code= :id2', [':id2' => $cur->code])->All()) {
	    $modelc = new Rates();
		$modelc->cur_code = $cur->code;
		$modelc->cur_name = $cur->namecode;
		$modelc->bank_id = $id;
        $modelc->save(); }
		
		foreach ($table->find('tr') as $elem) {
		 $model = Rates::find()->Where('cur_name = :id', [':id' => $cur->namecode])->andwhere('bank_id = :id2', [':id2' => $id])->one();
		 
		
		 
			$pq = pq($elem);
			
			if (preg_replace('/\s/', '', strip_tags(preg_replace ("/[^A-Z\s]/","",$pq->find('td:eq(0)')->html()))) == $cur->namecode)
				
				{
				$out .= $pq->find('td:eq(1)')->html().'- УЕ <br/>';
				$koef = floatval($pq->find('td:eq(1)')->html());
			    $out .= $pq->find('td:eq(3)')->html();
			    $out .= $pq->find('td:eq(4)')->html().$cur->namecode.'<br/>';
				$model->buy  = 	floatval(str_replace(",", ".", $pq->find('td:eq(3)')->html()));
				$model->sell = 	floatval(str_replace(",", ".", $pq->find('td:eq(4)')->html()));
				if ($koef > 1) {$model->buy  = $model->buy / $koef;$model->sell  = $model->sell / $koef; }
				$model->save();	
				}
			
			
		}
		
		$bank->time = date("d.m.Y".' '.date("H:i"));
		$bank->save();
		}
        }else {$out='parsOff';}
        return $this->render('index', ['news' => $out, 'bank' =>$bank]);}
		
		
    public function actionParser2 ($id) {

//создаем таблицу курсов (если её нет) по объекту валют
    $currens = $this->findCurrency();
	
		
	    $bank = Banks::findOne($id);
		
		if ($bank->pars) {
		
        $client = new Client();
        $res = $client->request('GET', $bank->parsurl);
        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);
        foreach ($currens as $cur) {
		
		if (!Rates::find()->Where('Bank_id = :id', [':id' => $id])->andWhere ('cur_code= :id2', [':id2' => $cur->code])->All()) {
	    $modelc = new Rates();
		$modelc->cur_code = $cur->code;
		$modelc->cur_name = $cur->namecode;
		$modelc->bank_id = $id;
        $modelc->save(); }	
			
			
		foreach ($document->find('#buy_'.mb_strtolower($cur->namecode)) as $elem) {
            $model = Rates::find()->Where('cur_name = :id', [':id' => $cur->namecode])->andwhere('bank_id = :id2', [':id2' => $id])->one();
			$pq = pq($elem);
			$out .= $pq.$cur->namecode.'<br/>';
			$model->buy = $pq->html();
		    $model->save();
        }
		foreach ($document->find('#sell_'.mb_strtolower($cur->namecode)) as $elem) {
            $model = Rates::find()->Where('cur_name = :id', [':id' => $cur->namecode])->andwhere('bank_id = :id2', [':id2' => $id])->one();
			$pq = pq($elem);
			$out .= $pq.$cur->namecode.'<br/>';
			$model->sell = $pq->html();
		    $model->save();
			
        }
		$bank->time = date("d.m.Y".' '.date("H:i"));
	    $bank->save();
		}
        }else {$out='parsOff';}
        return $this->render('index', ['news' => $out, 'bank' =>$bank]);}
		
		
		
		 public function actionParser3 ($id) { 
	    $bank = Banks::findOne($id);
		$currens = Currency::find()->All();
		if ($bank->pars) {
		$client = new Client();
        $res = $client->request('GET', $bank->parsurl);
        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);
        foreach ($currens as $cur) {
		foreach ($document->find('td.font-size-large[data-currencies-code='.$cur->namecode.']') as $elem) {
            $model = Rates::find()->Where('cur_name = :id', [':id' => $cur->namecode])->andwhere('bank_id = :id2', [':id2' => $id])->one();
			$pq = pq($elem);
			$out .= $pq->attr('data-currencies-rate-buy');
			$out .= $pq->attr('data-currencies-rate-sell').$cur->namecode.'<br/>';
			 if ($pq->attr('data-currencies-rate-buy')!= '') {$model->buy = $pq->attr('data-currencies-rate-buy');}
			 if ($pq->attr('data-currencies-rate-sell')!= '') {$model->sell = floatval($pq->attr('data-currencies-rate-sell'));}
			 
			  $model->save();
			  
        }
		$bank->time = date("d.m.Y".' '.date("H:i"));
		$bank->save();
		}
        }else {$out='parsOff';}
        return $this->render('index', ['news' => $out, 'bank' =>$bank]);}
		
		
		// Поиск модели активных курсов
    protected function findCurrency(){
    if (($currency = Currency::find()->where('State = :id', [':id' => '1'])->All()) !== null) {
        return $currency;
	}}
		
}
