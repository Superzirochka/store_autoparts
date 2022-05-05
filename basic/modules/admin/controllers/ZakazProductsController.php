<?php

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\ZakazProducts;
use app\modules\admin\models\Kurs;
use app\modules\admin\models\ZakazProductsSearch;
use app\modules\admin\controllers\AdminController;
use app\modules\admin\models\ExelZakazADDForm;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\admin\models\Supplier;
use yii\web\UploadedFile;

/**
 * ZakazProductsController implements the CRUD actions for ZakazProducts model.
 */
class ZakazProductsController extends AdminController
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
     * Lists all ZakazProducts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ZakazProductsSearch();
        $dataProvider = $searchModel->search(
            // Yii::$app->request->get()
            Yii::$app->request->queryParams
        );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExseladd()
    {
        $model = new ExelZakazADDForm();

        if ($model->load(Yii::$app->request->post())
            // && $model->validate()
        ) {
            $supplier = $model->supplier;
            $link = $model->link;
            $model->file = UploadedFile::getInstance($model, 'file');
            if (!empty($model->file)) {
                $model->file->saveAs('excelprod/' . $model->file);

                $data = \moonland\phpexcel\Excel::widget([
                    'mode' => 'import',
                    'fileName' => 'excelprod/' . $model->file,
                    //  'setFirstRecordAsKeys' => true, // если вы хотите установить ключи столбца записи с первой записью, если она не установлена, заголовок с использованием столбца алфавита в excel.
                    // 'setIndexSheetByName' => true, // установите это, если ваши данные Excel с несколькими листами, индекс массива будет установлен с именем листа. Если этот параметр не установлен, индекс будет использовать числовой формат.
                    //   'getOnlySheet' => 'sheet1', // вы можете установить это свойство, если хотите получить указанный лист из данных Excel с несколькими листами.
                ]);
            }

            return $this->render('loadexcel', [
                'data' =>  $data, 'fileName' => $model->file, 'supplier' => $supplier,
                'link' => $link
            ]);
        }

        return $this->render('exseladd', [
            'model' =>  $model,
        ]);
    }
    //

    public function actionLoadexcel()
    {
        $currentKurs = Kurs::find()->where(['Id' => 1])->one();
        $fileName = $_GET['fileName']['name'];
        $session = Yii::$app->session;
        $session->open();
        if ($session->has('kurs')) {
            $kurs = $session->get('kurs');
        } else {
            $session->set('kurs', ['kurs' => $currentKurs->Current_kurs]);
        }
        //  var_dump( $fileName);
        if ($_GET['add'] == 'add') {
            $today = date("Y-m-d H:i:s");
            // $allproducts=Products::find();
            $supplier = $_GET['supplier'];
           // var_dump($supplier);
            $link = $_GET['link'];

            $data = \moonland\phpexcel\Excel::widget([
                'mode' => 'import',
                'fileName' => 'excelprod/' . $fileName,

            ]);
            $itemZakaz =  \moonland\phpexcel\Excel::widget([
                'mode' => 'import',
                'fileName' => 'excelprod/pic.xls',

            ]);
            // echo "link";

            // echo "<br>";
            // var_dump($itemZakaz);

            foreach ($data as $item) {
                $bdproduct = '';
                $bdproduct = ZakazProducts::findOne(['Supplier' => $supplier, 'Brand' => $item['Brand'], 'ProductName' => $item['ProductName']]);
                for ($i = 0; $i < count($itemZakaz); $i++) {
                    // $fotoItem = preg_replace('#[ ]#u', '', trim($itemZakaz[$i]['FORMA']));   
                    if (!empty($link)) {
                        if ($supplier == 1) {
                            if (trim($itemZakaz[$i]['FORMA']) == trim($item['ProductName'])) {
                                $foto = $link . trim(preg_replace('#[jpg]#u', '', $itemZakaz[$i]['PIC'])) . '.jpg';
                                // var_dump($foto);
                            }
                        } else {
                            if (empty($item['Img'])) {
                                $foto = $link . trim($item['ProductName']) . '.jpg';
                            } else {
                                $foto = $link . $item['Img'];
                            }
                        }
                    } else {
                        $foto = $link;
                    }
                }
                $markup = $this->getMarkup($item['EntryPrice']);

                if (!empty($bdproduct)) {
                    \Yii::$app
                        ->db
                        ->createCommand()
                        ->update('zakaz_products', [
                            //'ProductName' => $item['ProductName'], 
                            //'Description' => $model->Description,
                            // 'Supplier' => $model->Supplier,  
                            //'Img' => $model->Img, 
                            //'Brand' => $model->Brand, 
                            'EntryPrice' => $item['EntryPrice'] / $currentKurs->Current_kurs,
                            'Markup' => $markup, 'Price' =>  $item['EntryPrice'] * (1 + $markup / 100), 'TermsDelive' => $item['TermsDelive'],
                            'Count' => $item['Count']
                        ], 'Id=' . $bdproduct->Id)
                        ->execute();
                } else {
                    \Yii::$app
                        ->db
                        ->createCommand()
                        ->insert('zakaz_products', [
                            'ProductName' => $item['ProductName'], 'Description' => $item['Description'],
                            'Supplier' =>  $supplier,  'Img' => $foto, 'Brand' => $item['Brand'], 'EntryPrice' => $item['EntryPrice'] / $currentKurs->Current_kurs,
                            'Markup' => $markup, 'Price' => $item['EntryPrice'] * (1 + $markup / 100), 'TermsDelive' => $item['TermsDelive'],
                            'Count' => preg_replace('#[>, <]#u', ' ', $item['Count'])
                        ])
                        ->execute();
                }
            }

            return $this->redirect(
                'index'
                //  , [
                // 'dataProvider' => $dataProvider,
                //  ]
            );
        }
        // return $this->render('exseladd', [
        //     'model' =>  $model,
        // ]);
    }

    /**
     * Displays a single ZakazProducts model.
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
     * Creates a new ZakazProducts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ZakazProducts();

        $kurs =  Kurs::find()->where(['Id' => 1])->one();

        if (
            $model->load(Yii::$app->request->post())
            //&& $model->save()
        ) {

            //  $Supplier = Supplier::find()->where(['Id' => $model->Supplier])->one();
            \Yii::$app
                ->db
                ->createCommand()
                ->insert('zakaz_products', [
                    'ProductName' => $model->ProductName, 'Description' => $model->Description,
                    'Supplier' => $model->Supplier,  'Img' => $model->Img, 'Brand' => $model->Brand, 'EntryPrice' => $model->EntryPrice,
                    'Markup' => $model->Markup, 'Price' => $model->EntryPrice * $kurs->Current_kurs * (1 + $model->Markup / 100), 'TermsDelive' => $model->TermsDelive,
                    'Count' => $model->Count
                ])
                ->execute();
            return $this->redirect(['index']);
            //return $this->redirect(['view', 'id' => $model->Id]);
        }

        return $this->render('create', [
            'model' => $model, //'kurs' => $kurs
        ]);
    }

    public function getMarkup($data)
    {
        if ($data <= 100) {
            return 100;
        }
        if ($data > 100 && $data <= 200) {
            return 70;
        }
        if ($data > 200 && $data <= 500) {
            return 50;
        }
        if ($data > 500 && $data <= 800) {
            return 30;
        }
        if ($data > 800 && $data <= 1200) {
            return 20;
        }
        if ($data > 1200 && $data <= 2000) {
            return 15;
        }
        if ($data > 2000) {
            return 10;
        }
    }

    /**
     * Updates an existing ZakazProducts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $kurs =  Kurs::find()->where(['Id' => 1])->one();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (is_int($model->Supplier)) {
                $Supplier = Supplier::find()->where(['Id' => $model->Supplier])->one();
            } else {
                $Supplier = Supplier::find()->where(['Supplier' => $model->Supplier])->one();
            }
            \Yii::$app
                ->db
                ->createCommand()
                ->update('zakaz_products', [
                    'ProductName' => $model->ProductName, 'Description' => $model->Description,
                    'Supplier' => $model->Supplier,  'Img' => $model->Img, 'Brand' => $model->Brand, 'EntryPrice' => $model->EntryPrice,
                    'Markup' => $model->Markup, 'Price' => $model->EntryPrice * $kurs->Current_kurs * (1 + $model->Markup / 100), 'TermsDelive' => $model->TermsDelive,
                    'Count' => $model->Count
                ], 'Id=' . $model->Id)
                ->execute();
            return $this->redirect(['view', 'id' => $model->Id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ZakazProducts model.
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
     * Finds the ZakazProducts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ZakazProducts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ZakazProducts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
