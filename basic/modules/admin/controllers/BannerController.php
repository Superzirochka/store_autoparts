<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Banner;
use app\modules\admin\models\BannerImg;
use yii\data\ActiveDataProvider;
use app\modules\admin\controllers\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BannerController implements the CRUD actions for Banner model.
 */
class BannerController extends AdminController
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
     * Lists all Banner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Banner::find(),
        ]);
        $dataAll = Banner::find()->select(['Id', 'Name', 'Status'])->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'dataAll' => $dataAll,

        ]);
    }

    /**
     * Displays a single Banner model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionImages($id)

    {
        $banner = $this->findModel($id);
        $images = BannerImg::find()->select(['Id', 'IdBanner', 'Title', 'Link', 'Img'])->where(['IdBanner' => $id])->all();
        return $this->render('images', [
            'images' => $images,
            'banner' => $banner
        ]);
    }

    public function actionAddimg($id)
    {
        $model = new BannerImg();
        $model->IdBanner = $id;
        $banner = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())
            //&& $model->save()
        ) {
            $imageName = time();
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if (!empty($model->imageFile)) {
                $model->imageFile->saveAs('img/sliders/' . $banner->Name . '/' . $imageName . '.' . $model->imageFile->extension);
                $model->Img = 'sliders/' . $banner->Name . '/' . $imageName . '.' . $model->imageFile->extension;
            }

            \Yii::$app
                ->db
                ->createCommand()
                ->insert('banner_img', [
                    'IdBanner' => $model->IdBanner, 'Title' => $model->Title, 'Img' => $model->Img,
                    'Link' => $model->Link
                ])
                ->execute();
            return $this->redirect(['images', 'id' => $model->IdBanner]);
        }

        return $this->render('addimg', [
            'model' => $model,
            'banner' => $banner,
            'id' => $id
        ]);
    }

    public function actionDeleteimg($id)
    {
        \Yii::$app
            ->db
            ->createCommand()
            ->delete('banner_img', 'Id=' . $id)
            ->execute();
        $banner = $this->findModel($id);
        $images = BannerImg::find()->select(['Id', 'IdBanner', 'Title', 'Link', 'Img'])->where(['IdBanner' => $id])->all();
        return $this->render('images', [
            'images' => $images,
            'name' => $banner->Name
        ]);
    }

    public function actionUpdateimg($id)
    {
        $model = BannerImg::findOne($id);
        $banner = $this->findModel($model->IdBanner);
        if ($model->load(Yii::$app->request->post())
            //&& $model->save()
        ) {
            $imageName = time();
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if (!empty($model->imageFile)) {
                $model->imageFile->saveAs('img/sliders/' . $banner->Name . '/' . $imageName . '.' . $model->imageFile->extension);
                $model->Img = 'sliders/' . $banner->Name . '/' . $imageName . '.' . $model->imageFile->extension;
            }

            \Yii::$app
                ->db
                ->createCommand()
                ->update('banner_img', [
                    'IdBanner' => $model->IdBanner, 'Title' => $model->Title, 'Img' => $model->Img,
                    'Link' => $model->Link
                ], 'Id=' . $model->Id)
                ->execute();

            return $this->redirect(['images', 'id' => $model->IdBanner]);
        }

        return $this->render('updateimg', [
            'model' => $model
        ]);
    }
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Banner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Banner();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->Id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Banner model.
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
     * Deletes an existing Banner model.
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
     * Finds the Banner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Banner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banner::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
