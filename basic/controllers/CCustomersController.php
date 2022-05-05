<?

namespace app\controllers;

use app\models\Customers;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use yii\web\Response;

class CustomersController extends ActiveController
{


    public $modelClass = 'app\models\Customers';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'customers',
    ];


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors =  \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
            ],
        ]);
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return $behaviors;
        //   return

    }
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => Customers::find(),
        ]);
    }
    public function actionView($id)
    {
        return Customers::findOne($id);
    }

    public function actions()
    {
        $actions = parent::actions();

        // отключить действия "delete" и "create"
        unset($actions['delete'], $actions['create']);

        // настроить подготовку провайдера данных с помощью метода "prepareDataProvider()"
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }
    public function prepareDataProvider()
    {
        // подготовить и вернуть провайдер данных для действия "index"
        return new ActiveDataProvider([
            'query' => Customers::find(),
        ]);
    }
}
