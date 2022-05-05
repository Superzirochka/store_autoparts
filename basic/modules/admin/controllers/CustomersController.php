<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Customers;
use app\modules\admin\models\GpuopCustomers;
use yii\data\ActiveDataProvider;
use app\modules\admin\controllers\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomersController implements the CRUD actions for Customers model.
 */
class CustomersController extends AdminController
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
     * Lists all Customers models.
     * @return mixed
     */
    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Customers::find()
                ->orderBy(['Status' => SORT_DESC]),
            'sort' => false,
            'pagination' => [
                // три заказа на страницу
                'pageSize' => 3,
                // уникальный параметр пагинации
                'pageParam' => 'process',
            ]
        ]);

        $groupCustom = new ActiveDataProvider([
            'query' =>  GpuopCustomers::find()
                ->orderBy(['Id' => SORT_ASC]),
            'sort' => false,
            'pagination' => [
                // три заказа на страницу
                'pageSize' => 3,
                // уникальный параметр пагинации
                'pageParam' => 'process',

            ]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'groupCustom' => $groupCustom,
        ]);
    }

    /**
     * Displays a single Customers model.
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


    public function actionAddgruop()
    {
        $model = new GpuopCustomers();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('addgruop', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Customers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customers();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->Id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Customers model.
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

    public function actionInfo($id)
    {
        $model = GpuopCustomers::findOne($id);

        if ($model->load(Yii::$app->request->post())
            // && $model->save()
        ) {

            \Yii::$app
                ->db
                ->createCommand()
                ->update('gpuop_customers', ['Name' => $model->Name], 'Id=' . $model->Id)
                ->execute();
            return $this->redirect(['index']);
        }

        return $this->render('addgruop', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Customers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionDelgruop($id)
    { //delgruop
        $model = GpuopCustomers::findOne($id);
        $products = Customers::find()->where(['IdGruop' => $id])->all();
        if (!empty($products)) {
            Yii::$app->session->setFlash(
                'warning',
                'Нельзя удалить группу покупателей, в которой есть покупатели'
            );
            return $this->redirect(['index']);
        } else {
            $model->delete();
        }

        return $this->redirect(['index']);
    }
    public function actionDelete($id)
    {
        $customer = $this->findModel($id);
        \Yii::$app
            ->db
            ->createCommand()
            ->update('customers', ['Status' => 0], 'Id=' . $id)
            ->execute();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Customers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customers::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
