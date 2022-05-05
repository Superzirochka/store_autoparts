<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Store;
use yii\data\ActiveDataProvider;
use app\modules\admin\controllers\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;

/**
 * StoreController implements the CRUD actions for Store model.
 */
class StoreController extends AdminController
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
     * Lists all Store models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Store::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Store model.
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
     * Creates a new Store model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Store();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->Id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Store model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())
            // && $model->save()
        ) {

            $imageName = time();
            $model->logoBig = UploadedFile::getInstance($model, 'logoBig');
            $model->logoSmall = UploadedFile::getInstance($model, 'logoSmall');

            if (!empty($model->logoBig)) {
                $model->logoBig->saveAs('img/logo-' . $imageName . '.' . $model->logoBig->extension);
                $model->Logo = 'logo-' . $imageName . '.' . $model->logoBig->extension;
            }
            if (!empty($model->logoSmall)) {
                $model->logoSmall->saveAs('img/logoSmall-' . $imageName . '.' . $model->logoSmall->extension);
                $model->logo_small = 'logoSmall-' . $imageName . '.' . $model->logoSmall->extension;
            }

            \Yii::$app
                ->db
                ->createCommand()
                ->update('store', ['Name_shop' => $model->Name_shop, 'Description' => $model->Description, 'Meta_title' => $model->Meta_title, 'Meta_description' => $model->Meta_description, 'Meta_keyword' => $model->Meta_keyword, 'Phone' => $model->Phone, 'Viber' => $model->Viber, 'Facebook_link' => $model->Facebook_link, 'Work_time' => $model->Work_time, 'Email' => $model->Email, 'Adress' => $model->Adress, 'Date_add' => $model->Date_add, 'Owner' => $model->Owner, 'Telegram_link' => $model->Telegram_link, 'Google_map' => $model->Google_map, 'Logo' => $model->Logo, 'Id_lang' => 1, 'logo_small' => $model->logo_small, 'Description_ua' => $model->Description_ua, 'Meta_title_ua' => $model->Meta_title_ua, 'Meta_description_ua' => $model->Meta_description_ua, 'Meta_keyword_ua' => $model->Meta_keyword_ua, 'Info' => $model->Info, 'Adress_ua' => $model->Adress_ua, 'Work_time_ua' => $model->Work_time_ua], 'Id=' . $model->Id)
                ->execute();

            return $this->redirect(['view', 'id' => $model->Id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Store model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Store model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Store the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Store::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii ::t('app', 'The requested page does not exist.'));
    }
}
