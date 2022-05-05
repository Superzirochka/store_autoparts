<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii;



class AdminController extends Controller
{

    public function beforeAction($action)
    {
        $session = Yii::$app->session;
        $session->open();
        if (!$session->has('auth_site_admin')) {
            $this->redirect('auth/login');
            return false;
        }
        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $session = Yii::$app->session;
        $session->open();

        if ($_GET['exit'] == 'ex') {
            if ($session->has('auth_site_admin')) {
                $session->remove('auth_site_admin');
            }
        }
    }
}
