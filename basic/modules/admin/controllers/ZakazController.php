<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Zakaz;
use yii\data\ActiveDataProvider;
use app\modules\admin\controllers\AdminController;
use app\modules\admin\models\ModelAuto;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ZakazController implements the CRUD actions for Zakaz model.
 */
class ZakazController extends AdminController
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
     * Lists all Zakaz models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Zakaz::find(),
            'pagination' => [
                'pageSize' => 5, // пять заказов на страницу

            ],
            'sort' => [
                'defaultOrder' => [
                    // сортировка по статусу, по возрастанию
                    'DateAdd' => SORT_DESC,
                    'Status' => SORT_DESC //ASC
                ]
            ]
        ]);



        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Zakaz model.
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
     * Creates a new Zakaz model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCreate()
    // {
    //     $model = new Zakaz();

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['view', 'id' => $model->Id]);
    //     }
    //     $option = [];


    //     return $this->render('create', [
    //         'model' => $model, 'option' => $option
    //     ]);
    // }

    /**
     * Updates an existing Zakaz model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->Id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Zakaz model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        return $this->redirect(['index']);
    }

    public function actionAjax()

    {
        //     $option = '';
        if (\Yii::$app->request->isAjax) {

            Yii::$app->response->format = Response::FORMAT_JSON;
            $id = ($_GET['data']);
            //(int)Yii::$app->request->post('data');
            $option = '';
            $modelsAuto =  ModelAuto::find()->select(['ModelName', 'Id'])
                ->where(['IdManufacturer' => $id])
                ->orderBy('ModelName')
                ->all();

            if (count($modelsAuto) > 0) {
                foreach ($modelsAuto as $modelAuto) {
                    $option .= '<option value="' . $modelAuto->Id . '">' . $modelAuto->ModelName . '</option>';
                }
            } else {
                $option = '<option>-</option>';
            }

            return  $option;
            // 'Запрос принят!';
        }
        //     return $option;
    }

    /**
     * Finds the Zakaz model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Zakaz the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Zakaz::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
