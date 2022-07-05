<?php

namespace app\controllers;

use yii\web\Controller;
use Yii;
use app\models\Page;


class AppController extends Controller
{

    public $pageMenu;
    /*...*/
    public function beforeAction($action)
    {
        $session = Yii::$app->session;
        $session->open();
        if (!$session->has('lang')) {
        $lang = ['Id' => 1, 'language' => 'Українська', 'Abb' => 'ua'];
        $session->set('lang', $lang);
         }
        if (!$session->has('cart')) {
            $session->set('cart', []);
        }
        if (!$session->has('wish_auto')) {
            $session->set('wish_auto', []);
            return  [];
        }
        if (!$session->has('current')) {
            $current = ['Id' => 1, 'Name' => 'ГРН', 'Small_name' => '₴'];
            $session->set('current', $current);
        }
        if (!$session->has('customer')) {
            $customer = ['Id' => 1, 'FName' => 'Гість'];
            $session->set('customer', $customer);
        }
        if (!$session->has('greeting')) {
            $greeting = 'Добрий день';
            $session->set('greeting', $greeting);
        }

        $this->pageMenu = Page::getTree();
        return parent::beforeAction($action);
    }
    /**
     * Метод устанавливает мета-теги для страницы сайта
     * @param string $title
     * @param string $keywords
     * @param string $description
     */
    protected function setMetaTags($title = '', $keywords = '', $description = '')
    {
        $this->view->registerMetaTag([
            'name' => 'ShopName',
            'content' => Yii::$app->params['shopName']
        ]);
        $this->view->title = $title ?: Yii::$app->params['defaultTitle'];
        $this->view->registerMetaTag([
            'name' => 'keywords',
            'content' => $keywords ?: Yii::$app->params['defaultKeywords']
        ]);

        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => $description ?: Yii::$app->params['defaultDescription']
        ]);
    }



    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
