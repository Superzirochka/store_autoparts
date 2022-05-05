<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\models\Products;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;
use yii\web\Response;

/**
 * @OA\Tag(
 *   name="Products",
 *   description="Everything about your Products",
 *   @OA\ExternalDocumentation(
 *     description="更多相关",
 *     url="http://dakara.cn"
 *   )
 * )
 */
class ProductsController extends ActiveController
{
    public $modelClass = 'app\modules\api\models\Products';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    // public function actions()
    // {
    //     $actions = parent::actions();

    //     // отключить действия "delete" и "create"
    //     // unset($actions['delete'], $actions['create']);

    //     // // настроить подготовку провайдера данных с помощью метода "prepareDataProvider()"
    //     // $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

    //     return $actions;
    // }
    public function actions()
    {

        $actions = [
            'create' => [
                'class'       => 'app\modules\api\controllers',
                'modelClass'  => $this->modelClass,
                //'checkAccess' => [$this, 'checkAccess'],
                'params'      => \Yii::$app->request->post()
            ],
        ];

        return array_merge(parent::actions(), $actions);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors =  \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);

        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
        //   return

    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Products::find(),
        ]);
        return $dataProvider;
    }


    public function actionCreate()
    {
        $model = new Products();
        var_dump($model->load(Yii::$app->getRequest()->getBodyParams(), ''));
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->save()) {
            $response = Yii::$app->createRequest()
                ->getResponse();

            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute(['view', 'id' => $id], true));
            return $model;
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->getBodyParams(), '') && $model->save()) {
            Yii::$app->response->setStatusCode(200);
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }
        return $model;
    }


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        // if ($model->softDelete() === false) {
        //     throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        // }
        Yii::$app->getResponse()->setStatusCode(204);
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
        throw new NotFoundHttpException('The requested Products does not exist.');
    }

    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD', 'POST'],
            'view' => ['GET', 'HEAD', 'POST'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH', 'POST'],
            'delete' => ['DELETE'],
        ];
    }
}
