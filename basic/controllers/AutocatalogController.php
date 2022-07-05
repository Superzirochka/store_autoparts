<?php

namespace app\controllers;

use app\models\AutoForm;
use app\models\Engine;
use app\models\ManufacturerAuto;
use app\models\ModelAuto;
use app\models\Modification;
use app\models\NodeAuto;
use app\models\Oem;
use app\models\Products;
use app\models\ValueEngine;
use app\models\ZakazProducts;
use Yii;
use app\models\Kurs;

class AutocatalogController extends AppController
{
    public function actionIndex(
        // $marka, $models, $modification
    )
    {
        $session = Yii::$app->session;
        $session->open();

        $id = $_GET['id'];
        $model = new AutoForm();
        $marka = $_GET['marka'];
        $models = $_GET['models'];
        $modification = $_GET['modification'];
        // $model = new AutoForm();
        // if (\Yii::$app->request->isAjax) {
        // }

        if (Yii::$app->request->isAjax) {


            if (!empty($_GET['model'])) {
                $id = ($_GET['model']);
                $option = '';
                $modif =  Modification::find()->select(['IdModelAuto', 'IdEngine', 'IdValueEngine', 'Id'])
                    ->where(['IdModelAuto' => $id])
                    //->orderBy('ModelName')
                    ->all();


                if (count($modif) > 0) {
                    $option .= '<option>Выберите...</option>';
                    foreach ($modif as $modelAuto) {
                        $engine = Engine::find()->select('Name, Id')->where(['Id' => $modelAuto->IdEngine])->one();
                        $value = ValueEngine::find()->select('Value, Id')->where(['Id' => $modelAuto->IdValueEngine])->one();

                        $option .= '<option value="' . $modelAuto->Id . '">' . $engine->Name . ' ' . $value->Value . '</option>';
                    }
                } else {
                    $option = '<option >-</option>';
                }

                return $option; // 'Запрос принят!'.$_GET['data'];
            }
            if (!empty($_GET['data'])) {
                $id = ($_GET['data']);
                $option = '';
                $modelsAuto =  ModelAuto::find()->select(['ModelName', 'constructioninterval', 'Id'])
                    ->where(['IdManufacturer' => $id])
                    ->orderBy('ModelName')
                    ->all();

                if (count($modelsAuto) > 0) {
                    $option .= '<option >Выберите...</option>';
                    foreach ($modelsAuto as $modelAuto) {
                        $option .= '<option value="' . $modelAuto->Id . '">' . $modelAuto->ModelName . ' ' . $modelAuto->constructioninterval . '</option>';
                    }
                } else {
                    $option = '<option >-</option>';
                }

                return $option; // 'Запрос принят!'.$_GET['data'];

            }
        }

        if (
            $model->load(Yii::$app->request->post())
            && $model->validate() && $model->model != 0 && $model->modification != 0
        ) {

            $marka = $model->marka;
            //  echo $marka;
            $models = $model['model'];
            $modification = $model['modification'];
            $autoMarka = [
                'marka' => $marka,
                'models' =>  $models,
                'modification' =>  $modification
            ];
            $session->set('autoMarka', $autoMarka);
            return $this->redirect([
                'autocatalog/index', 'marka' => $marka, 'models' => $models, 'modification' => $modification,
                //$id => ''
            ]);
        }

        $oem = Oem::find()->where(['Id_auto' => $modification])->all();
        $nodes = NodeAuto::find()->all();

        return $this->render('index', [
            'models' => ModelAuto::findOne(['Id' => $models]),
            'marka' => ManufacturerAuto::findOne(['Id' => $marka]),
            'modification' => Modification::findOne(['Id' => $modification]),
            'oem' => $oem,
            'nodes' => $nodes,
            'model' => $model,
            'id' => $id
        ]);
    }

    public function actionSearch($search = '', $page = 1)
    {
        $kurs = Kurs::find()->where(['Id' => 1])->one();
        $page = (int)$page;
        $session = Yii::$app->session;
        $session->open();
        $carts = $session->get('cart');
        if (!$session->has('customer')) {
            $customer = ['Id' => 1, 'FName' => 'Гість'];
            $session->set('customer', $customer);
        } else {
            $customer = $session->get('customer');
        }

        if (!$session->has('current')) {
            $current = ['Id' => 1, 'Name' => 'ГРН', 'Small_name' => '₴'];
            $session->set('current', $current);
        } else {
            $current = $session->get('current');
        }
        $wishlist = $this->getWishSession();
        if (($_GET['wish'] == 'add')) {
            $session = Yii::$app->session;
            $session->open();
            $wishlist = $this->getWishSession();
            $id = abs((int) $_GET['id']);
            $product = Products::findOne($id);

            // if (!empty($product)) {
            //     throw new \yii\web\HttpException(404, 'Такого товара нет');
            // }     


            // if (!isset($wishlist['products'][$product->Id]))
            // {
            if (isset($wishlist['products'][$product->Id])) { // такой товар уже есть?
                throw new \yii\web\HttpException(404, 'Данный товар уже добавлен в список желаний');
            } else { // такого товара еще нет
                $wishlist['products'][$product->Id]['Id'] = $product->Id;
                $wishlist['products'][$product->Id]['Name'] = $product->Name;
                $wishlist['products'][$product->Id]['Price'] = $product->Price;
                $wishlist['products'][$product->Id]['MinQunt'] = $product->MinQunt;
            }

            $session->set('wish_auto', $wishlist);
            $this->redirect(Yii::$app->request->referrer);
        }

        $autoMarka = $session->get('autoMarka');
        $markaSes = ManufacturerAuto::findOne(['Id' => $autoMarka['marka']]);
        $modelsSes = ModelAuto::findOne(['Id' => $autoMarka['models']]);
        $modificationSes = Modification::findOne(['Id' => $autoMarka['modification']]);
        //print_r($modelsSes->FullName);


        if (($_GET['wish'] == 'del')) {
            $id = abs((int) $_GET['id']);

            if (isset($wishlist['products'][$id])) {
                unset($wishlist['products'][$id]);
                if ($customer['Id'] != 1) {
                    \Yii::$app
                        ->db
                        ->createCommand()
                        ->delete('wishlist', ['IdProduct' => $id, 'IdCustomer' => $customer['Id']])
                        ->execute();
                }
            }
            Yii::$app->session->set('wish_auto', $wishlist);
            $this->redirect(Yii::$app->request->referrer);
        }

        if ($_GET['addCart'] == 'add') {

            $id = abs((int) $_GET['id']);
            $product = Products::findOne($id);
            if (!empty($product)) {

                $count = $product->MinQunt;
            }


            if (isset($carts['products'][$product->Id])) { // такой товар уже есть?
                $count = $carts['products'][$product->Id]['Quanty'] + $count;

                if ($count > 100) {
                    $count = 100;
                }
                $carts['products'][$product->Id]['Quanty'] = $count;
            } else { // такого товара еще нет
                $carts['products'][$product->Id]['Id'] = $product->Id;
                $carts['products'][$product->Id]['Name'] = $product->Name;
                $carts['products'][$product->Id]['Price'] = $product->Price;
                $carts['products'][$product->Id]['Quanty'] = $count;
            }
            $amount = 0.0;
            foreach ($carts['products'] as $item) {
                $amount = $amount + $item['Price'] * $item['Quanty'];
            }
            $carts['amount'] = $amount;
            $session->set('cart', $carts);
            $this->redirect(Yii::$app->request->referrer);
        }

        if ($_GET['delCart'] == 'del') {
            $id = abs((int) $_GET['id']);
            $session = Yii::$app->session;
            $session->open();
            if (!$session->has('cart')) {
                $session->set('cart', []);
                $carts = [];
            }
            $carts = $session->get('cart');

            if (isset($carts['products'][$id])) {
                unset($carts['products'][$id]);
            }

            // if (!isset($carts['products'][$id])) {
            //     echo 'ok';
            // }

            if (count($carts['products']) == 0) {
                $session->set('cart', []);
            }
            $amount = 0.0;
            foreach ($carts['products'] as $item) {
                $amount = $amount + $item['Price'] * $item['Quanty'];
            }

            $carts['amount'] = $amount;

            $session->set('cart', $carts);
            $this->redirect(Yii::$app->request->referrer);
        }
        $oem = Oem::find()->where(['Id_auto' => $autoMarka['modification']])->all();
        $nodes = NodeAuto::find()->all();
        // получаем результаты поиска с постраничной навигацией

        list($products, $pages) = (new Products())-> //getSearchResult($search, $page);
            getSearchAutoResult($search, $page);

        // if (empty($products)) { 


        list($zakaz_products, $pagesZ) = (new ZakazProducts())->getSearchResult($search, $page);

        //  var_dump($zakaz_products );
        //}

        // устанавливаем мета-теги для страницы
        $this->setMetaTags('Поиск по каталогу');

        return $this->render(
            '../autoshop/search',
            //'search',
            compact(
                'products',
                'pages',
                'pagesZ',
                'wishlist',
                'carts',
                'markaSes',
                'modelsSes',
                'modificationSes',
                'oem',
                'nodes',
                'kurs',
                'current',
                'zakaz_products'
            )
        );
    }

    public function getCartSession()
    {
        $session = Yii::$app->session;
        $session->open();
        if (!$session->has('cart')) {
            $session->set('cart', []);
            return  [];
        } else {
            return   $session->get('cart');
        }
    }

    public function getWishSession()
    {
        $session = Yii::$app->session;
        $session->open();
        if (!$session->has('wish_auto')) {
            $session->set('wish_auto', []);
            return  [];
        } else {
            return   $session->get('wish_auto');
        }
    }
}
