<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Analog;
use app\modules\admin\models\AnalogSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class AnalogController extends \app\modules\admin\controllers\AdminController
{
    public function actionIndex($oem = '')
    {

        if ($oem == '') {
            $analog =  Analog::find()->orderBy(['Analog' => SORT_DESC]);
        } else {
            $analog =  Analog::find()->where(['OEM' => $oem])->orderBy(['Analog' => SORT_DESC]);
        }

        $searchModel = new AnalogSearch();
        //  var_dump($oem);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $oem);
        // $dataprovide = new ActiveDataProvider([
        //     'query' => $analog
        //     //Products::find()->where(['in', 'Tegs', $oem->OEM])
        // ]);
        return $this->render('index', [
            'oem' => $oem,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionView($oem, $analog)
    {
        $model = $this->findModel($oem, $analog);
        //var_dump($model->Brand);
        return $this->render('view', [
            'model' => $model
        ]);
    }


    /**
     * Creates a new BrandProd model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Analog();

        if ($model->load(Yii::$app->request->post())) {
            $model1 = Analog::find()->select('OEM, Marka, Brand, Analog')->where(['OEM' => $model->OEM, 'Analog' => $model->Analog])->all();
            //  $this->findModel($model->OEM, $model->Analog);
            if (count($model1) == null) {
                \Yii::$app
                    ->db
                    ->createCommand()
                    ->insert('analog', [
                        'Analog' => $model->Analog, 'Marka' => $model->Marka,
                        'Brand' => $model->Brand,  'OEM' => $model->OEM
                    ])
                    ->execute();
                return $this->redirect(['view', 'oem' => $model->OEM, 'analog' => $model->Analog]);
            } else {
                return 'такая позиция уже есть';
                //$this->redirect(['view', 'oem' => $model1->OEM, 'analog' => $model1->Analog]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionDelete($oem, $analog)
    {
        //  $this->findModel($oem, $analog)->delete();
        \Yii::$app
            ->db
            ->createCommand()
            //('DELETE FROM analog WHERE Analog=' . $analog . ' AND' . ' OEM=' . $oem)
            ->delete('analog', ['Analog' => $analog, 'OEM' => $oem])
            ->execute();

        return $this->redirect(['index']);
    }
    /**
     * Updates an existing BrandProd model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($oem, $analog)
    {
        $model = $this->findModel($oem, $analog);
        $aaa = $model->Analog;
        $ooo = $model->OEM;
        if ($model->load(Yii::$app->request->post())) {
            \Yii::$app
                ->db
                ->createCommand()
                ->update('analog', [
                    'Analog' => $model->Analog, 'Marka' => $model->Marka,
                    'Brand' => $model->Brand,  'OEM' => $model->OEM
                ], ['Analog' => $aaa, 'OEM' => $ooo])
                ->execute();
            return $this->redirect(['index']);
            //, 'oem' => $model->OEM, 'analog' => $model->Analog]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the BrandProd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BrandProd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($oem, $analog)
    {
        $model = Analog::find()->select('OEM, Marka, Brand, Analog')->where(['OEM' => $oem, 'Analog' => $analog])->one();

        if ($model) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'Запрошенная страница не существует.'));
    }
}
