<?php

namespace app\controllers;

use Yii;
use app\models\Banks;
use app\models\UploadImage;
use app\models\Currency;
use app\models\Rates;
use app\models\Office;
use app\models\BanksSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
 
class RatesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
		'access' => [
                'class' => AccessControl::className(),
             
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    // Выборка активных валют, проверка и добавление курсов по активным валютам, вывод информации по банку, отображение курсов банка
	 
	public function actionIndex($id) {
	 	 
    $currency = $this->findCurrency();
	
	//цикл по объекту валют
	foreach ($currency as $ccode) {
    if (!Rates::find()->Where('Bank_id = :id', [':id' => $id])->andWhere ('cur_code= :id2', [':id2' => $ccode->code])->All()) {
	    $model = new Rates();
		$model->cur_code = $ccode->code;
		$model->cur_name = $ccode->namecode;
		$model->bank_id = $id;
        $model->save(); }
			}
    
	    $bank = Banks::findOne($id);
	    $query = Rates::find()->Where('Bank_id = :id', [':id' => $id]);
	    $dataProvider = new ActiveDataProvider([
            'query' => $query,
		 ]);
		return $this->render ('rates',[
		'dataProvider'=> $dataProvider, 'name'=>$bank->name, 'pars'=>$bank->pars, 'lrate'=>$bank->lrate,'model'=>$model, 'Bank_id'=>$bank->id, ]);
}	

    // Апдейт курсов
    public function actionUpdate ($id,$bank_id) {
	
	$model = $this->findModel($id);
	if (($bank = Banks::findOne($bank_id)) !== null) {
	$bank->time='';
	$bank->save();}
	if ($model->load(Yii::$app->request->post()) && $model->save()) {
		 Yii::$app->getSession()->setFlash('success','Данные сохранены');
        return $this->actionIndex($bank_id);  
        }
	
}    // Удаление курса
     public function actionRatedel($id,$bank_id)
    {    
	   $this->findModel2($id)->delete();
        return $this->redirect(['rates/index', 'id'=>$bank_id]);
		}
		



    // Поиск модели курса для апдейта
    protected function findModel($id) { 

    if (($model = Rates::findOne($id)) !== null) {
        return $model;
        }
    throw new NotFoundHttpException('The requested page does not exist.');
 }
    // Поиск модели активных курсов
    protected function findCurrency(){
    if (($currency = Currency::find()->where('State = :id', [':id' => '1'])->All()) !== null) {
        return $currency;
        }

    throw new NotFoundHttpException('The requested page does not exist.');
    }
	protected function findModel2($id)
    {
        if (($model = Rates::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	}