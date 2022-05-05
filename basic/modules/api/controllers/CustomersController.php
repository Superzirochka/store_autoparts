<?

namespace app\modules\api\controllers;

use app\models\User;
use app\modules\api\models\Customers;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use yii\web\Response;

class CustomersController extends ActiveController
{


    public $modelClass = 'app\modules\api\models\Customers';
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
        // return Customers::find();

        return new ActiveDataProvider([
            'query' => Customers::find(),
        ]);
    }

    public function actionView($id)
    {
        return Customers::findOne($id);
    }

    // public function actionDelete($id)
    // {
    //     return 'OK';
    // }

    public function actions()
    {
        $actions = parent::actions();

        // отключить действия "delete" и "create"
        unset(
            $actions['delete']
            //,
            // $actions['create']
        );

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

    public function actionCreate()
    {
        $model = new Customers();
        if ($model->load(Yii::$app->request->post())) {
            // if ($model->save()) {
            return $model;
            // }
            //    return $model->errors; //or whatever you want
        }
        // if ($model->load(Yii::$app->request->post())) {
        //     $user = new Customers();
        //     $today = date("Y-m-d");
        //     $user->Login = $model->Login;
        //     $user->hash = md5(microtime());
        //     $user->FName = $model->Fname;
        //     $user->LName = $model->Lname;
        //     $user->Email = $model->Email;
        //     $user->Phone = $model->Phone;
        //     $user->City = $model->City;
        //     $user->News = $model->News;
        //     if ($model->Adres == null) {
        //         $model->adres = 'Харьков самовывоз';
        //     }
        //     $user->Adres = $model->Adres;
        //     $user->IdGruop = 1;
        //     $user->Password = \Yii::$app->security->generatePasswordHash($model->Password);
        //     //echo '<pre>'; print_r($user); die;
        //     //$user->save();
        //     \Yii::$app
        //         ->db
        //         ->createCommand()
        //         ->insert('customers', ['Login' => $user->Login, 'password_reset_token' => $user->hash, 'hash' => $user->hash, 'FName' => $user->FName,   'LName' => $user->LName, 'Email' => $user->Email,  'Phone' => $user->Phone, 'News' => $user->News, 'City' => $user->City, 'Adres' => $user->Adres, 'IdGruop' => $user->IdGruop, 'Password' => $user->Password, 'Status' => 10, 'DateRegistration' => $today])
        //         ->execute();
        //     // if ($user->save()) {
        //     //  $session->set('customer', []);
        //     $c = User::findByUsername($user->Login);
        //     ///  $customer = ['Id' => $c['Id'], 'FName' => $user->FName];
        //     // $session->set('customer', $customer);
        //     return $model;
        // }
        // } else {
        //  return $model; //or whatever you want
        // }
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
