<?

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Products;
use app\modules\admin\models\ZakazProducts;
use app\modules\admin\models\ProductsSearch;
use app\modules\admin\models\Reviews;
use app\modules\admin\models\Analog;
use app\modules\admin\models\ProductImg;
use app\modules\admin\models\RecommendProds;
use app\modules\admin\models\ExelADDForm;
use app\modules\admin\models\Kurs;
use yii\data\ActiveDataProvider;
use app\modules\admin\controllers\AdminController;
use app\modules\admin\models\Category;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use \yii\imagine\Image;
//use \phpexcel\Excel;
//use \phpoffice\phpexcel\PHPExcel;
//use moonlandsoft\phpspreadsheet\Excel;


/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends AdminController
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
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = Kurs::find()->where(['Id' => 1])->one();
        $session = Yii::$app->session;
        $session->open();
        if ($session->has('kurs')) {
            $kurs = $session->get('kurs');
        } else {
            $session->set('kurs', ['kurs' => $model->Current_kurs]);
        }


        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataReviews = new ActiveDataProvider([
            'query' => Reviews::find()->orderBy('Id DESC'),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        $products = Products::find()->where(['Status' => 10])->all();
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $session->set('kurs', ['kurs' => $model['Current_kurs']]);
            foreach ($products as $prod) {
                $price = $prod->Conventional_units * (1 + $prod->Markup / 100) * $model['Current_kurs'];
                \Yii::$app
                    ->db
                    ->createCommand()
                    ->update('products', [
                        'Price' => $price
                    ], 'Id=' . $prod->Id)
                    ->execute();
            }

            return $this->redirect('index');
        }



        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataReviews' => $dataReviews,
            'model' => $model,
            //'searchModel' => $searchModel,
        ]);
    }

    public function actionExseladd()
    {
        $model = new ExelADDForm();

        if ($model->load(Yii::$app->request->post())
            // && $model->validate()
        ) {
            $category = $model->category;
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
                'data' =>  $data, 'fileName' => $model->file, 'Id_category' => $category, 'IdBrand' => $model->brand
            ]);
        }

        return $this->render('exseladd', [
            'model' =>  $model,
        ]);
    }
    //

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
            $Id_category = $_GET['Id_category'];
            $IdBrand = $_GET['IdBrand'];
            $data = \moonland\phpexcel\Excel::widget([
                'mode' => 'import',
                'fileName' => 'excelprod/' . $fileName,

            ]);
            foreach ($data as $item) {
                $bdproduct = '';
                $bdproduct = Products::findOne(['Name' => $item['Name'], 'IdBrand' => $IdBrand]);
                $markup = $this->getMarkup($item['Price']);
                if (!empty($item['Id_discont'])) {
                    $disc = $item['Id_discont'];
                } else {
                    $disc = 1;
                }
                //->select('Id', 'Name', 'IdBrand')
                // ->where(['Name' => $item['Name'], 'IdBrand'=>$item['IdBrand']])
                // ->asArray()->one();
                //  foreach($allproducts as $product){
                if (!empty($bdproduct))
                //if ($product->Name==$item['Name'] && $product->IdBrand==$item['IdBrand'])
                {
                    // var_dump ($bdproduct);   
                    //   echo $bdproduct['Id'];   

                    $price = $item['Price'] / $kurs['kurs'];
                    $itemPrice = $price * (1 + $markup / 100) * $kurs['kurs'];

                    \Yii::$app
                        ->db
                        ->createCommand()
                        ->update('products', ['Conventional_units' => $price, 'Status' => 10, 'Price' => $itemPrice, 'Markup' => $markup, 'Availability' => $item['Availability']], 'Id=' . $bdproduct['Id'])
                        //->where(['Id='.$bdproduct->Id])
                        ->execute();
                    // $count++;
                    //return $this->redirect('index');
                    // }
                } else

                // if($count==0)
                {
                    if (empty($item['Img'])) {
                        $item['Img'] = 'products/' . $item['Name'] . '.jpg';
                    }
                    if (empty($item['Img2'])) {
                        $item['Img2'] = 'products/' . $item['Name'] . '-b.jpg';
                    }

                    $price = $item['Price'] / $kurs['kurs'];
                    $itemPrice = $price * (1 + $markup / 100) * $kurs['kurs'];


                    \Yii::$app
                        ->db
                        ->createCommand()
                        ->insert('products', ['Name' => $item['Name'], 'Description' => $item['Description'],  'Description_ua' => $item['Description_ua'], 'Img' => $item['Img'], 'Img2' => $item['Img2'], 'Tegs' => $item['Tegs'], 'MetaDescription' => $item['MetaDescription'], 'MetaTitle' => $item['MetaTitle'], 'MetaKeyword' => $item['MetaKeyword'], 'MetaDescription_ua' => $item['MetaDescription_ua'], 'MetaTitle_ua' => $item['MetaTitle_ua'], 'MetaKeyword_ua' => $item['MetaKeyword_ua'], 'IdBrand' => $IdBrand, 'Id_lang' => 1, 'Id_category' => $Id_category, 'Conventional_units' => $price, 'Price' => $itemPrice, 'Markup' => $markup, 'Id_discont' => $disc, 'Availability' => $item['Availability'], 'Id_current' => 1, 'MinQunt' => $item['MinQunt'], 'Units' => $item['Units'], 'DateAdd' => $today])
                        ->execute();
                }
            }

            // $dataProvider = new ActiveDataProvider([
            //     'query' => Products::find(),
            // ]);
            return $this->redirect(
                'index'
                //  , [
                // 'dataProvider' => $dataProvider,
                //  ]
            );
        }
        return $this->redirect('exseladd');
    }

    public function actionItemadd($id)
    {
        $Name = $this->findModel($id);
        $recom = RecommendProds::find()->where(['Id_products' => $id])->all();
        $model = new  RecommendProds();

        $model->Id_products = $id;
        if ($model->load(Yii::$app->request->post())) {
            $count = 0;
            foreach ($recom as $r) {
                if ($r->Id_recomend == $model->Id_recomend) {
                    $count++;
                }
            }

            if ($count == 0) {
                $model->save();
                return $this->redirect(['view', 'id' => $id]);
            } else {
                Yii::$app->session->setFlash(
                    'warning',
                    'Такой рекомендованый товар уже есть'
                );
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        return $this->render('itemadd', [
            'model' => $model,
            'Name' => $Name->Name,
            'id' => $id
        ]);
    }

    public function actionDelrecom($id, $idrec)
    {
        \Yii::$app
            ->db
            ->createCommand()
            ->delete('recommend_prods', ['Id_products' => $id, 'Id_recomend' => $idrec])
            ->execute();
        return $this->redirect(['view', 'id' => $id]);
    }


    /**
     * Displays a single Products model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $prodAll = Products::find()->asArray()->all();
        // $moreImg=Products::getProductImgs($id)->all();
        $recomProd = [];
        $recommend = RecommendProds::find()
            ->where(['Id_products' => $id])
            ->asArray()
            ->all();
        foreach ($recommend as $rec) {
            foreach ($prodAll as $all) {

                if ($rec->Id_recomend ==  $all->Id) {
                    array_push($recomProd, $all);
                }
            }
        }

        $recomProd = new ActiveDataProvider([
            'query' => RecommendProds::find()->where(['Id_products' => $id]),
        ]);
        $item = $this->findModel($id);

        $searchQuery = Products::find()->Where(['Id' => !$id]);
        $searchQuery = $searchQuery->Where(['like', 'Tegs', $item->Name]);

        $temp = explode(',', $item->Tegs);
        //   var_dump($temp);
        $arrayAnalog = [];
        if (!empty($temp)) {
            for ($t = 0; $t < count($temp); $t++) {

                // if(!empty($temp[$t])){
                $analogs = Analog::find()->where(['OEM' => $temp[$t]])->all();
                foreach ($analogs as $analog) {
                    $arrayAnalog[] = $analog->Analog;
                }
                //}

            }
        }
        if (!empty($arrayAnalog)) {
            for ($i = 0; $i < count($arrayAnalog); $i++) {
                // if (!empty($arrayAnalog[$i])){
                $searchQuery = $searchQuery->orWhere(['like', 'Name', $arrayAnalog[$i]]);
                $searchQuery = $searchQuery->orWhere(['like', 'Tegs', $arrayAnalog[$i]]);
            }
            //}
        }
        if (!empty($temp)) {
            for ($t = 0; $t < count($temp); $t++) {
                $searchQuery = $searchQuery->orWhere(['like', 'Name', $temp[$t]]);
                $searchQuery = $searchQuery->orWhere(['like', 'Tegs', $temp[$t]]);
            }
        }
        //var_dump($searchQuery);
        $searchQuery->orderBy(['Name' => SORT_DESC])->all();

        $newAnalog =  new ActiveDataProvider([
            'query' => $searchQuery,
        ]);

        //   $reviews = new ActiveDataProvider([
        //     'query' =>Reviews::find()->where(['IdProduct' => $id]),
        //     ]);
        $moreImg = ProductImg::find()
            ->where(['IdProduct' => $id])
            ->asArray()->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'newAnalog' => $newAnalog,
            // 'id'=>$id
            'moreImg' => $moreImg,
            //'reviews'=> $reviews,
            'recomProd' => $recomProd
        ]);
    }



    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = Yii::$app->session;
        $session->open();
        $kurs = $session->get('kurs');
        $kurs = Kurs::find()->Where(['Id' => 1])->one();
        $model = new Products();
        if (!empty($_GET['oem'])) {
            $model->Tegs = $_GET['oem'];
        }
        if ($model->load(Yii::$app->request->post())
            //&& $model->save()
        ) {
            $itemNew = Products::find()->where([
                'Name' => $model->Name,
                'IdBrand' => $model->IdBrand,
            ])->one();
            if (empty($itemNew)) {
                // $imageName = time();
                $model->imageFile1 = UploadedFile::getInstance($model, 'imageFile1');
                $model->imageFile2 = UploadedFile::getInstance($model, 'imageFile2');
                $today = date("Y-m-d H:i:s");
                if (!empty($model->imageFile1)) {
                    $model->imageFile1->saveAs('img/products/' . $model->Name . '-a.' . $model->imageFile1->extension);
                    $model->Img = 'products/' . $model->Name . '-a.' . $model->imageFile1->extension;
                } else {
                    $model->Img = 'products/defult_prodact.jpg';
                }
                if (!empty($model->imageFile2)) {
                    $model->imageFile2->saveAs('img/products/' . $model->Name . '-b.' . $model->imageFile2->extension);
                    $model->Img2 = 'products/' . $model->Name . '-b.' . $model->imageFile2->extension;
                } else {
                    $model->Img2 = 'products/defult_prodact.jpg';
                }
                //$i=+($kurs['kurs']);

                $price = $model->Conventional_units * (1 + $model->Markup / 100) * $kurs->Current_kurs;
                //var_dump($price);
                \Yii::$app
                    ->db
                    ->createCommand()
                    ->insert('products', [
                        'Name' => $model->Name, 'Description' => $model->Description,
                        'Description_ua' => $model->Description_ua,  'Img' => $model->Img, 'Img2' => $model->Img2, 'Tegs' => $model->Tegs,
                        'MetaDescription' => $model->MetaDescription, 'MetaTitle' => $model->MetaTitle, 'MetaKeyword' => $model->MetaKeyword,
                        'MetaDescription_ua' => $model->MetaDescription_ua, 'MetaTitle_ua' => $model->MetaTitle_ua, 'MetaKeyword_ua' => $model->MetaKeyword_ua, 'IdBrand' => $model->IdBrand, 'Id_lang' => 1, 'Id_category' => $model->Id_category, 'Price' => $price, 'Id_discont' => $model->Id_discont,
                        'Conventional_units' => $model->Conventional_units,
                        'Markup' => $model->Markup,
                        'Availability' => $model->Availability, 'Id_current' => $model->Id_current, 'MinQunt' => $model->MinQunt, 'Units' => $model->Units, 'Status' => $model->Status, 'DateAdd' => $today
                    ])
                    ->execute();
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash(
                    'warning',
                    'Такой товар уже есть'
                );
                return $this->redirect(['index']);
            }
        }


        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->Id]);
        // }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDeleteimg($img)
    {
        \Yii::$app
            ->db
            ->createCommand()
            ->delete('product_img', ['Img' => $img])
            ->execute();

        return $this->redirect(['view']);
    }

    public function actionImgadd($id)
    {
        $dopimg = new ProductImg();
        $moreImg = ProductImg::find()
            ->where(['IdProduct' => $id])
            ->asArray()->all();
        $prod = $this->findModel($id);
        if ($dopimg->load(Yii::$app->request->post())) {
            $imageName = time();
            $dopimg->fileupload = UploadedFile::getInstance($dopimg, 'fileupload');
            if (!empty($dopimg->fileupload)) {
                $dopimg->fileupload->saveAs('img/products/' . $prod->Name . '-' . $imageName . '.' . $dopimg->fileupload->extension);
                $dopimg->Img = 'products/' . $prod->Name . '-' . $imageName . '.' . $dopimg->fileupload->extension;
            }

            \Yii::$app
                ->db
                ->createCommand()
                ->insert('product_img', ['IdProduct' => $prod->Id, 'Img' => $dopimg->Img])
                ->execute();
            $moreImg = ProductImg::find()
                ->where(['IdProduct' => $id])
                ->asArray()->all();
            return $this->render('imgadd', [
                'model' => $this->findModel($id),
                // 'id'=>$id
                'moreImg' => $moreImg,
                'dopimg' => $dopimg,
                //  'recomProd'=>$recomProd
            ]);
        }

        return $this->render('imgadd', [
            'model' => $this->findModel($id),
            // 'id'=>$id
            'moreImg' => $moreImg,
            'dopimg' => $dopimg,
            //  'recomProd'=>$recomProd
        ]);
    }


    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old1 = $model->Img;
        $old2 = $model->Img2;
        $kurs = Kurs::find()->Where(['Id' => 1])->one();
        if ($model->load(Yii::$app->request->post())
            //&& $model->save()
        ) {
            $imageName = time();
            $model->imageFile1 = UploadedFile::getInstance($model, 'imageFile1');
            $model->imageFile2 = UploadedFile::getInstance($model, 'imageFile2');
            $today = date("Y-m-d H:i:s");
            if (!empty($model->imageFile1)) {
                $model->imageFile1->saveAs('img/products/' . $model->Name . '-a.' . $model->imageFile1->extension);
                $model->Img = 'products/' . $model->Name . '-a.' . $model->imageFile1->extension;
            }
            if (!empty($model->imageFile2)) {
                $model->imageFile2->saveAs('img/products/' . $model->Name . '-b.' . $model->imageFile2->extension);
                $model->Img2 = 'products/' . $model->Name . '-b.' . $model->imageFile2->extension;
            }
            $price = $model->Conventional_units * (1 + $model->Markup / 100) * $kurs->Current_kurs;
            \Yii::$app
                ->db
                ->createCommand()
                ->update('products', [
                    'Name' => $model->Name, 'Description' => $model->Description,
                    'Description_ua' => $model->Description_ua, 'Img' => $model->Img, 'Img2' => $model->Img2, 'Tegs' => $model->Tegs, 'MetaDescription' => $model->MetaDescription, 'MetaTitle' => $model->MetaTitle, 'MetaKeyword' => $model->MetaKeyword,
                    'MetaDescription_ua' => $model->MetaDescription_ua, 'MetaTitle_ua' => $model->MetaTitle_ua, 'MetaKeyword_ua' => $model->MetaKeyword_ua,  'IdBrand' => $model->IdBrand, 'Id_lang' => 1, 'Id_category' => $model->Id_category, 'Price' => $price, 'Id_discont' => $model->Id_discont,
                    'Conventional_units' => $model->Conventional_units,
                    'Markup' => $model->Markup, 'DateAdd' => $today,
                    'Availability' => $model->Availability, 'Id_current' => $model->Id_current, 'MinQunt' => $model->MinQunt, 'Units' => $model->Units, 'Status' => $model->Status
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
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();
        \Yii::$app
            ->db
            ->createCommand()
            ->update('products', ['Status' => 0], 'Id=' . $id)
            ->execute();
        return $this->redirect(['index']);
    }


    public function actionSearch($query = '')
    {
        $query = $this->cleanSearchString($query);
        $search = preg_replace('#[ ]#u', '', $query);
        $analogs = Analog::find()->where(['OEM' => $query])->all();
        $analogSearch = Analog::find()->where(['OEM' => $search])->all();
        $searchQuery = Products::find()->where(['like', 'Name', $query])
            ->orWhere(['like', 'Tegs', $query])
            ->orwhere(['like', 'Name', $search])
            ->orWhere(['like', 'Tegs', $search]);
        if (!empty($analogs)) {
            foreach ($analogs as $analog) {
                $searchQuery = $searchQuery->orWhere(['like', 'Name', $analog->Analog]);
            }
        }
        if (!empty($analogSearch)) {
            foreach ($analogSearch as $analogSea) {
                $searchQuery = $searchQuery->orWhere(['like', 'Name', $analogSea->Analog]);
            }
        }
        $searchQuery->orderBy(['Name' => SORT_DESC]);
        $searchZakaz = ZakazProducts::find()->where(['like', 'ProductName', $query]);

        if (!empty($analogs)) {
            foreach ($analogs as $analog) {
                $searchZakaz = $searchZakaz->orWhere(['like', 'ProductName', $analog->Analog]);
            }
        }
        if (!empty($analogSearch)) {
            foreach ($analogSearch as $analogSea) {
                $searchZakaz = $searchZakaz->orWhere(['like', 'ProductName', $analogSea->Analog]);
            }
        }
        $searchZakaz->orderBy(['ProductName' => SORT_DESC]);
        // var_dump($products);
        //$searchQuery= (new Products())->getSearchAnalogResult($query);
        $dataProvider = new ActiveDataProvider([
            'query' => $searchQuery,
        ]);
        $dataProviderZakaz =  new ActiveDataProvider([
            'query' => $searchZakaz,
        ]);
        return $this->render('search', ['query' => $query, 'dataProvider' => $dataProvider, 'dataProviderZakaz' => $dataProviderZakaz]);
    }

    protected function cleanSearchString($search)
    {
        $search = iconv_substr($search, 0, 64);
        // удаляем все, кроме букв и цифр
        // $search = preg_replace('#[-]#u', ' ', $search); //убирает -
        $search = preg_replace('#[^0-9a-zA-ZА-Яа-яёЁ\-]#u', ' ', $search); // исключаем -' \-'
        // сжимаем двойные пробелы
        $search = preg_replace('#\s+#u', ' ', $search);
        //  
        $search = trim($search);
        return $search;
    }


    public function actionDeleterew($id)
    {
        \Yii::$app
            ->db
            ->createCommand()
            ->delete('reviews', 'Id=' . $id)
            ->execute();
        $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'Запрашиваемая страница не существует.'));
    }
}
