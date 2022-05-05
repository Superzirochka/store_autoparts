<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Actions;
use yii\data\ActiveDataProvider;
use app\modules\admin\controllers\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ActionsController implements the CRUD actions for Actions model.
 */
class ActionsController extends AdminController
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
     * Lists all Actions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Actions::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Actions model.
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
     * Creates a new Actions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Actions();
        $model->DateAdd = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post())
            //&& $model->save()
        ) {
            $imageName = time();
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if (!empty($model->imageFile)) {
                $model->imageFile->saveAs('img/action/' . $imageName . '.' . $model->imageFile->extension);
                $model->Img = 'action/' . $imageName . '.' . $model->imageFile->extension;
            }
            \Yii::$app
                ->db
                ->createCommand()
                ->insert('actions', [
                    'Name' => $model->Name, 'Slug' => $model->Slug, 'Img' => $model->Img,
                    'Content' => $model->Content,
                    'KeyWord' => $model->KeyWord,
                    'MetaDescription' => $model->MetaDescription,
                    'DateAdd' =>  $model->DateAdd,
                ])
                ->execute();


            return $this->redirect(['index']);
        }
        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->Id]);
        // }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Actions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->DateAdd = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post())
            //&& $model->save()
        ) {
            $imageName = time();
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if (!empty($model->imageFile)) {
                $model->imageFile->saveAs('img/action/' . $imageName . '.' . $model->imageFile->extension);
                $model->Img = 'action/' . $imageName . '.' . $model->imageFile->extension;
            }
            \Yii::$app
                ->db
                ->createCommand()
                ->update('actions', [
                    'Name' => $model->Name, 'Slug' => $model->Slug, 'Img' => $model->Img,
                    'Content' => $model->Content,
                    'KeyWord' => $model->KeyWord,
                    'MetaDescription' => $model->MetaDescription,
                    'DateAdd' =>  $model->DateAdd,
                ], 'Id=' . $model->Id)
                ->execute();
            return $this->redirect(['index']);
        }

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->Id]);
        // }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Actions model.
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
     * Finds the Actions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Actions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Actions::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
