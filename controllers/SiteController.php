<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\Banks;
use app\models\Clients;
use app\models\UploadImage;
use app\models\Currency;
use app\models\Rates;
use app\models\Office;
use app\models\BanksSearch;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Site;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use yii\web\UrlRuleInterface;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {   $model = new Site();
	    $cur = $model->findCurrency();
		$banks= Banks::find()->count();
		$off= Office::find()->count();
		$ords= Clients::find()->count();
		$contact = new ContactForm();
        if ($contact->load(Yii::$app->request->post()) && $contact->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
		
        return $this->render('index',[
            'model' => $model, 'cur' => $cur,'banks' => $banks,'off' => $off,'ords' => $ords, 'contact' => $contact,
        ]);
    }
	
	 public function actionShowchange($id) {
		$model = new Site();
	    $cur = $model->findCurrency();
		 
		 if ($model->load(Yii::$app->request->post()))
		 { $grid=true;
		 
		   
		   if ($model->incur == 643) {
		  
		   $ratesout = Rates::find()->where('cur_code = :id', [':id' =>$model->outcur ])->all();
		   foreach ($ratesout as $rateid =>$rate){
           $incur = Rates::findOne(['cur_code'=>$model->incur, 'bank_id' => $rate->bank_id]);if ($rate->sell >1 ){
		   if (Banks::findOne(['id' => $rate->bank_id])->lrate == '1' and  $model->cashin >= $incur->lrate and $rate->sell_l > 1) {

     	   $rate->res =   $model->cashin / $rate->sell_l; $rate->ratex = $rate->sell_l;} else 
           { $rate->res =   $model->cashin / $rate->sell; $rate->ratex = $rate->sell;}
	       $rate->res = number_format($rate->res, 2, '.', ''); }  
	    
		else {unset($ratesout[$rateid]);}  }
	   
	   $sort=SORT_DESC;
	   
	
	   } 
			  
		   
		   
		   elseif ($model->outcur != 643) {
				  
			 
			$ratesout = Rates::find()->where('cur_code = :id', [':id' =>$model->outcur ])->all();
		   foreach ($ratesout as $rateid =>$rate ){
     
		$incur = Rates::findOne(['cur_code'=>$model->incur, 'bank_id' => $rate->bank_id]);  if ($incur->buy > 1 and $rate->buy >1 ){
		$rate->res = ($incur->buy / $rate->buy)*$model->cashin; $rate->ratex = $rate->buy;
		   $rate->res = number_format($rate->res, 2, '.', ''); }  else {unset($ratesout[$rateid]);}
			
			//
		   }
		   }
		   
		   elseif ($model->outcur == 643) {$ratesout = Rates::find()->where('cur_code = :id', [':id' =>$model->incur ])->all();
		 
		   foreach ($ratesout as $rateid =>$rate){
			   if ($rate->buy > 1 ){
                   if (Banks::findOne(['id' => $rate->bank_id])->lrate == '1' and  $model->cashin >= $rate->lrate and $rate->sell_l > 1 ) {
		           $rate->res = $rate->buy_l * $model->cashin; $rate->cur_name = 'RUR'; $rate->ratex = $rate->buy_l;   }
		           else { $rate->res = $rate->buy * $model->cashin; $rate->cur_name = 'RUR'; $rate->ratex = $rate->buy; }
		           $rate->res = number_format($rate->res, 2, '.', '');} 
		      
			   else {unset($ratesout[$rateid]);}
		     
		   }
		   $sort=SORT_DESC;
		   }
			  
			  
			  } 
			  
		
		 $dataProvider = new ArrayDataProvider([
            'allModels' => $ratesout,
			'sort' => [
        'attributes' => [
            'res' => []
        ],
        'defaultOrder' => [
            'res' => $sort  ]  ]
			
         ]);
		 $modelcl = new Clients();
		  $cur2 = Currency::findOne(['code' => $id]);
		return $this->render('index',[
             'model' => $model,'modelcl' => $modelcl, 'cur' => $cur,'cur2' => $cur2, 'dataProvider'=> $dataProvider, 'grid' => $grid, 'inc'=>$ratesout,
        ]);
		 }
		  
		  

		  
		  
		 
		 public function actionMap($id)
    {
		$model = Office::find()->where('bank_id = :id',[':id' => $id])->all();
		$name = Banks::findOne(['id' => $id])->name;
        return $this->render('map', [
            'model' => $model,'name' => $name,
        ]);
    }
		 
		 
	 
	

    /**
     * Login action.
     *
     * @return Response|string
     */
	 
	 
	  public function actionContact()
    {
		
		if (Yii::$app->user->isGuest) {  return $this->actionLogin(); } else {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }}
	 
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
   

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
