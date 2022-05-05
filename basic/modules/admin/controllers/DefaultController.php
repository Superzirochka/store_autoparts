<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\OrdersShop;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends AdminController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $queueOrders = new ActiveDataProvider([
            'query' => OrdersShop::find()
                ->where(['Status' => 'new'])
                ->orderBy(['DateAdd' => SORT_DESC]),
            'sort' => false,
            'pagination' => [
                // три заказа на страницу
                'pageSize' => 3,
                // уникальный параметр пагинации
                'pageParam' => 'queue',

            ]
        ]);
        $processOrders = new ActiveDataProvider([
            'query' => OrdersShop::find()
                ->where(['IN', 'Status', ['processed', 'paid', 'delivered']])
                ->orderBy(['DateUpdate' => SORT_DESC]),
            'sort' => false,
            'pagination' => [
                // три заказа на страницу
                'pageSize' => 3,
                // уникальный параметр пагинации
                'pageParam' => 'process',

            ]
        ]);
        return $this->render('index', [
            'queueOrders' => $queueOrders,
            'processOrders' => $processOrders,
        ]);
    }
}
