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

/**
 * BanksController implements the CRUD actions for Banks model.
 */
class BanksController extends Controller
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

    /**
     * Lists all Banks models.
     * @return mixed
     */
	 
	 
	 public function actionOfficedel($id,$bank_id)
    {    
	   $this->findModel2($id)->delete();
        return $this->redirect(['office', 'id'=>$bank_id]);
		}
		
	 
	 public function actionOffice($id)
    {    
	
	    $model = new Office();
        $query = Office::find()->where('bank_id = :id', [':id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
		
		if ($model->load(Yii::$app->request->post()) && $model->save()) {}

        return $this->render('office', [
            'model' => $model,
            'dataProvider' => $dataProvider,
			'Bank_id' => $id,
			'name' => $this->findModel($id)->name,
        ]);
		
		
    } 
	
	

	 
	 
    public function actionIndex()
    {
        $searchModel = new BanksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Banks model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id), 
        ]);
    }
	
	
	
	

    /**
     * Creates a new Banks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Banks();
        $cur = $model->findCurrency();
        if ($model->load(Yii::$app->request->post()) ) {
			
		$model->image= UploadedFile::getInstance($model, 'image');
        
		if ($model->image->baseName !='' ) { $model->icon = '/uploads/'.$model->image->baseName.'.'.$model->image->extension; }
		$model->parsfile .= 'id='.$id;
		$model->save();
		if ($model->image && $model->upload() ) {
         }
			 return $this->redirect(['view', 'id' => $model->id]);
		}

        return $this->render('create', [
            'model' => $model, 'cur' => $cur,
			
        ]);
    }






    /**
     * Updates an existing Banks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
         $cur = $model->findCurrency();
        if ($model->load(Yii::$app->request->post())) {
            $model->image= UploadedFile::getInstance($model, 'image');
			 if ($model->image->baseName !='' ) { $model->icon = '/uploads/'.$model->image->baseName.'.'.$model->image->extension; }
			 if ($model->parsfile =='') {$model->parsfile .= 'id='.$id;}
		     $model->save();
		if ($model->image && $model->upload() ) {
         }
			return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model, 'cur' => $cur,
        ]);
    }

    /**
     * Deletes an existing Banks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Banks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Banks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banks::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findModel2($id)
    {
        if (($model = Office::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
