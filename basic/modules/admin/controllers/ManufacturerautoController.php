<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\ManufacturerAuto;
use app\modules\admin\models\ManufacturerautoSearch;
use app\modules\admin\controllers\AdminController;
use app\modules\admin\models\Analog;
use app\modules\admin\models\ModelAuto;
use app\modules\admin\models\OemSearch;
use app\modules\admin\models\ModelautoSearch;
use app\modules\admin\models\Modification;
use app\modules\admin\models\ModificationSearch;
use app\modules\admin\models\NodeAuto;
use app\modules\admin\models\Oem;
use app\modules\admin\models\Products;
//use app\modules\admin\models\ProductsSearch;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;
use yii\helpers\FileHelper;

/**
 * ManufacturerautoController implements the CRUD actions for ManufacturerAuto model.
 */
class ManufacturerautoController extends AdminController
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
     * Lists all ManufacturerAuto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ManufacturerautoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ManufacturerAuto model.
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
    public function actionViewoem($id)
    {
        $model = Oem::findOne($id);
        return $this->render('viewoem', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new ManufacturerAuto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreatemodel($idMarka)
    {
        $model = new ModelAuto();
        $marka = $this->findModel($idMarka);
        $model->IdManufacturer = $idMarka;

        if ($model->load(Yii::$app->request->post())
            //&& $model->save()
        ) {
            //$imageName = time();
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->FullName = $marka->Marka . ' ' . $model->ModelName;
            if (!empty($model->imageFile)) {
                $model->imageFile->saveAs('img/marks/models/' . $model->ModelName . '-' . $model->constructioninterval . '.' . $model->imageFile->extension);
                $model->Img = 'models/' . $model->ModelName . '-' . $model->constructioninterval . '.' . $model->imageFile->extension;
            }
            //   else{
            //     $model->Img='defultLogo.jpg';
            // }

            \Yii::$app
                ->db
                ->createCommand()
                ->insert('model_auto', [
                    'IdManufacturer' => $model->IdManufacturer,
                    'ModelName' => $model->ModelName, 'Img' => $model->Img,  'FullName' => $model->FullName, 'constructioninterval' => $model->constructioninterval
                ])
                ->execute();
            return $this->redirect(['index']);
        }

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->Id]);
        // }

        return $this->render('createmodel', [
            'model' => $model,
            'marka' => $marka->Marka
        ]);
    }

    public function actionCreate()
    {
        $model = new ManufacturerAuto();

        if ($model->load(Yii::$app->request->post())
            //&& $model->save()
        ) {
            //$imageName = time();
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if (!empty($model->imageFile)) {
                $model->imageFile->saveAs('img/marks/' . $model->Marka . '.' . $model->imageFile->extension);
                $model->Img = 'marks/' . $model->Marka . '.' . $model->imageFile->extension;
            }
            //   else{
            //     $model->Img='defultLogo.jpg';
            // }

            \Yii::$app
                ->db
                ->createCommand()
                ->insert('manufacturer_auto', ['Marka' => $model->Marka,   'Img' => $model->Img, 'Link' => $model->Link])
                ->execute();
            return $this->redirect(['index']);
        }

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['modelsauto', 'id' => $model->Id]);
        // }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ManufacturerAuto model.
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
            // $imageName = time();
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if (!empty($model->imageFile)) {
                $model->imageFile->saveAs('img/marks/' . $model->Marka . '.' . $model->imageFile->extension);
                $model->Img = 'marks/' . $model->Marka . '.' . $model->imageFile->extension;
            }

            \Yii::$app
                ->db
                ->createCommand()
                ->update('manufacturer_auto', [
                    'Marka' => $model->Marka,   'Img' => $model->Img, 'Link' => $model->Link
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

    public function actionUpdatemodel($id)
    {
        $model =  ModelAuto::find()->select('Id,
        IdManufacturer,
        ModelName,
        FullName,
        constructioninterval,
        Img')->where(['Id' => $id])->one();
        $marks = $this->findModel($model->IdManufacturer);

        if ($model->load(Yii::$app->request->post())
            //&& $model->save()
        ) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            // $imageName = time();
            $model->FullName = $marks->Marka . ' ' . $model->ModelName;


            if (!empty($model->imageFile)) {
                $model->imageFile->saveAs('img/marks/models/' . $model->ModelName . '-' . $model->constructioninterval . '.' . $model->imageFile->extension);
                $model->Img = 'models/' . $model->ModelName . '-' . $model->constructioninterval . '.' . $model->imageFile->extension;
            }

            // print_r($model);
            \Yii::$app
                ->db
                ->createCommand()
                ->update('model_auto', [
                    'ModelName' => $model->ModelName, 'Img' => $model->Img,  'FullName' => $model->FullName, 'constructioninterval' => $model->constructioninterval
                ], 'Id=' . $model->Id)
                ->execute();
            return $this->redirect(['modelsauto', 'id' => $model->IdManufacturer]);
        }

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['modelsauto', 'id' => $model->IdManufacturer]);
        // }
        //  print_r($model);
        return $this->render('updatemodel', [
            'model' => $model,
        ]);
    }

    public function actionModelsauto($id)
    {
        // $modelsAuto = new ActiveDataProvider([
        //     'query' => ModelAuto::find()->where(['in', 'IdManufacturer', $id])
        // ]);

        $searchModel = new ModelautoSearch();
        // $searchModel = $searchModel->findModel($id);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);


        return $this->render(
            'modelsauto',
            [
                'id' => $id,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'marka' => $this->findModel($id),
                // 'modelsAuto' => $modelsAuto,
            ]
        );
    }

    /**
     * Deletes an existing ManufacturerAuto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id); //->delete();

        return $this->redirect(['index']);
    }

    public function actionModification($id)
    {
        $modelAuto = ModelAuto::find()->where(['Id' => $id])->one();
        $searchModel = new ModificationSearch();
        // $searchModel = $searchModel->findModel($id);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render(
            'modification',
            [
                'modelAuto' => $modelAuto,
                //'id' => $id,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'marka' => $this->findModel($id),
                // 'modelsAuto' => $modelsAuto,
            ]
        );
    }

    public function actionCreatemodific($idModel)
    {
        $modelAuto = ModelAuto::find()->where(['Id' => $idModel])->one();
        $model = new Modification();
        $model->IdModelAuto = $modelAuto->Id;
        $marka = $this->findModel($modelAuto->IdManufacturer);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['modification', 'id' => $modelAuto->Id]);
        }
        return $this->render('createmodific', [
            'model' => $model,
            'marka' => $marka,
        ]);
    }

    public function actionProducts($OEM)
    {
        $oem = Oem::find()->where(['OEM' => $OEM])->one();
        //$searchModel = new ProductsSearch();
        //  $dataProvider = $searchModel->search(Yii::$app->request->get());
        $modific = Modification::find()->where(['Id' => $oem->Id_auto])->one();
        $modelAuto = ModelAuto::find()->where(['Id' => $modific->IdModelAuto])->one();
        $node = NodeAuto::find()->where(['Id' => $oem->IdNode])->one();
        // $ids = NodeAuto::getAllChildIds($oem->IdNode);
        // $ids[] = $oem->IdNode;
        $analog = Analog::find()->where(['OEM' => $OEM])->all();
        $analogs = [];
        foreach ($analog as $an) {
            array_push($analogs, $an->Analog);
        }
        $query = Products::find()->where(['LIKE', 'Tegs', $oem->OEM])
            ->orWhere(['LIKE', 'Name', $oem->OEM]); //->orderBy(['Name' => SORT_DESC]);
        for ($i = 0; $i < (count($analogs)); $i++) {
            $query = $query->orWhere(['like', 'Name', $analogs[$i]]);
            //print_r($query);
            $query = $query->orWhere(['like', 'Tegs', $analogs[$i]]);
        }
        $query = $query->orderBy(['Name' => SORT_DESC]);
        $products = new ActiveDataProvider([
            'query' => $query
            //Products::find()->where(['in', 'Tegs', $oem->OEM])
        ]);
        //var_dump($node);
        // $searchModel = new OemSearch();
        // $searchModel = $searchModel->findModel($id);
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        //  $node = NodeAuto::find()->all();
        return $this->render(
            'products',
            [
                'modific' => $modific,
                'modelAuto' => $modelAuto,
                'node' => $node,
                //  'searchModel' => $searchModel,
                'dataProvider' => $products,
                'marka' => $this->findModel($modelAuto->IdManufacturer),
                'oem' => $oem,
            ]
        );
    }

    public function actionOem($idmodif)
    {
        $modific = Modification::find()->where(['Id' => $idmodif])->one();
        $modelAuto = ModelAuto::find()->where(['Id' => $modific->IdModelAuto])->one();
        $searchModel = new OemSearch();
        //(new OemSearch())->findModel($idmodif);

        $query = //(new Oem())->findModel($idmodif);
            Oem::find()->where(['LIKE', 'Id_auto', $idmodif])
            ->orderBy(['IdNode' => SORT_DESC]);
        //var_dump($query);
        $dataProvider = new ActiveDataProvider([
            'query' => $query

        ]);
        // $data = Yii::$app->request->queryParams;
        //print_r($data);
        // $searchModel = $searchModel->findModel($idmodif);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $idmodif);
        $node = NodeAuto::find()->all();
        return $this->render(
            'oem',
            [
                'modific' => $modific,
                'modelAuto' => $modelAuto,
                'node' => $node,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                // 'marka' => $this->findModel($id),
                // 'modelsAuto' => $modelsAuto,
            ]
        );
    }

    public function actionCreateoem($idModif)
    {
        $modeific = Modification::find()->where(['Id' => $idModif])->one();
        $modelAuto = ModelAuto::find()->where(['Id' => $modeific->IdModelAuto])->one();
        $model = new Oem();
        $model->Id_auto = $idModif;
        // var_dump($modelAuto);
        $marka = $this->findModel($modelAuto->IdManufacturer);

        if ($model->load(Yii::$app->request->post())
            //&& $model->save()
        ) {
            //$imageName = time();
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if (!empty($model->imageFile)) {
                $model->imageFile->saveAs('img/oem/' . $model->OEM . '.' . $model->imageFile->extension);
                $model->Img = 'oem/' . $model->OEM . '.' . $model->imageFile->extension;
            }
            // 'Id' => Yii::t('app', 'ID'),
            // 'OEM' => Yii::t('app', 'OEM'),
            // 'IdNode' => Yii::t('app', 'Узел авто'),
            // 'Id_auto' => Yii::t('app', 'Модель авто'),
            // 'Img' => Yii::t('app', 'Изображение'),
            // 'imageFile' => Yii::t('app', 'Загрузить'),
            // 'Description' => Yii::t('app', 'Описание'),
            // 'Description_ua' => Yii::t('app', 'Опис'),

            \Yii::$app
                ->db
                ->createCommand()
                ->insert('oem', ['OEM' => $model->OEM,   'Img' => $model->Img, 'IdNode' => $model->IdNode, 'Id_auto' => $model->Id_auto, 'Description' => $model->Description, 'Description_ua' => $model->Description_ua])
                ->execute();
            return $this->redirect(['oem', 'idmodif' => $model->Id_auto]);
        }

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {

        //     return $this->redirect(['modification', 'id' => $modelAuto->Id]);
        // }
        return $this->render('createoem', [
            'idModif' => $idModif,
            'model' => $model,
            'marka' => $marka,
            'modelAuto' => $modelAuto,
            'modelAuto' => $modelAuto,
        ]);
    }

    public function actionUpdateoem($id)
    {
        $model = Oem::find()->where(['Id' => $id])->one();
        $modeific = Modification::find()->where(['Id' => $model->Id_auto])->one();
        $modelAuto = ModelAuto::find()->where(['Id' => $modeific->IdModelAuto])->one();

        //$model->Id_auto = $id;
        // var_dump($modelAuto);
        $marka = $this->findModel($modelAuto->IdManufacturer);

        if ($model->load(Yii::$app->request->post())
            //&& $model->save()
        ) {
            //$imageName = time();
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if (!empty($model->imageFile)) {
                $model->imageFile->saveAs('img/oem/' . $model->OEM . '.' . $model->imageFile->extension);
                $model->Img = 'oem/' . $model->OEM . '.' . $model->imageFile->extension;
            }
            // 'Id' => Yii::t('app', 'ID'),
            // 'OEM' => Yii::t('app', 'OEM'),
            // 'IdNode' => Yii::t('app', 'Узел авто'),
            // 'Id_auto' => Yii::t('app', 'Модель авто'),
            // 'Img' => Yii::t('app', 'Изображение'),
            // 'imageFile' => Yii::t('app', 'Загрузить'),
            // 'Description' => Yii::t('app', 'Описание'),
            // 'Description_ua' => Yii::t('app', 'Опис'),

            \Yii::$app
                ->db
                ->createCommand()
                ->update('oem', ['OEM' => $model->OEM,   'Img' => $model->Img, 'IdNode' => $model->IdNode, 'Id_auto' => $model->Id_auto, 'Description' => $model->Description, 'Description_ua' => $model->Description_ua], 'Id=' . $model->Id)
                ->execute();
            return $this->redirect(['oem', 'idmodif' => $model->Id_auto]);
        }

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {

        //     return $this->redirect(['modification', 'id' => $modelAuto->Id]);
        // }
        return $this->render('updateoem', [
            //'idModif' => $idModif,
            'model' => $model,
            'marka' => $marka,
            'modelAuto' => $modelAuto,
            'modelAuto' => $modelAuto,
        ]);
    }
    /**
     * Finds the ManufacturerAuto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ManufacturerAuto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ManufacturerAuto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
