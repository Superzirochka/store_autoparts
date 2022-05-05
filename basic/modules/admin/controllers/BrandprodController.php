<?

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\BrandProd;
use yii\data\ActiveDataProvider;
use app\modules\admin\controllers\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;
use yii\helpers\FileHelper;


/**
 * BrandprodController implements the CRUD actions for BrandProd model.
 */
class BrandprodController extends AdminController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
 
    /**
     * Lists all BrandProd models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => BrandProd::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionAjax(){
        if (\Yii::$app->request->isAjax) {
            $trimmed = trim($_GET['data'], 'C:\fakepath\/');
          // $img= UploadedFile::getInstance($model, 'imageFile');
            // Yii::$app->response->format = Response::FORMAT_JSON;
            // $id = ($_GET['data']);
            // //(int)Yii::$app->request->post('data');
            // $option = '';
            // $modelsAuto =  ModelAuto::find()->select(['ModelName', 'Id'])
            //     ->where(['IdManufacturer' => $id])
            //     ->orderBy('ModelName')
            //     ->all();

            // if (count($modelsAuto) > 0) {
            //     foreach ($modelsAuto as $modelAuto) {
            //         $option .= '<option value="' . $modelAuto->Id . '">' . $modelAuto->ModelName . '</option>';
            //     }
            // } else {
            //     $option = '<option>-</option>';
            // }

            return $trimmed;
            // $option;
            //'Запрос принят!';
        }
    }
    /**
     * Displays a single BrandProd model.
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
     * Creates a new BrandProd model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $brandAll=BrandProd::find()->select('Id', 'Brand', 'Img')->asArray()->all();
        $lastId = count($brandAll)+1;

        $model = new BrandProd();

      
        if ($model->load(Yii::$app->request->post()) 
        //&& $model->save()
        ) {
            $imageName = time();
           $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
          
          if(!empty($model->imageFile))
         {        
            $model->imageFile->saveAs('img/brend/'.$model->Brand.'-'.$imageName.'.'.$model->imageFile->extension);
           $model->Img = 'brend/'.$model->Brand.'-'.$imageName.'.'.$model->imageFile->extension;
          }else{
            $model->Img='brend/defultLogo.jpg';
        }
        
         \Yii::$app
         ->db
         ->createCommand()
         ->insert('brand_prod', ['Brand' => $model->Brand,   'Img' => $model->Img])
         ->execute();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BrandProd model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

      
        if ($model->load(Yii::$app->request->post())
         //&& $model->save()
         ) {
            $imageName = time();
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
           
           if(!empty($model->imageFile))
          {
             $model->imageFile->saveAs('img/brend/'.$model->Brand.'-'.$imageName.'.'.$model->imageFile->extension);
            $model->Img = 'brend/'.$model->Brand.'-'.$imageName.'.'.$model->imageFile->extension;
             
           }

           \Yii::$app
                ->db
                ->createCommand()
                ->update('brand_prod', [
                    'Brand' => $model->Brand,   'Img' => $model->Img
                ], 'Id=' . $model->Id)
                ->execute();
             return $this->redirect(['view', 'id' => $model->Id]);
        }

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->Id]);
        // }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    

    /**
     * Deletes an existing BrandProd model.
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
     * Finds the BrandProd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BrandProd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BrandProd::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'Запрошенная страница не существует.'));
    }
}