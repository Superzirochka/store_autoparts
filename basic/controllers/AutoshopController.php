<?

namespace app\controllers;

use Yii;
use yii\httpclient\Client;

use yii\bootstrap\Alert;
use yii\helpers\Url;
use app\models\Store;
use app\models\Actions;
use app\models\Products;
use app\models\ZakazProducts;
use app\models\BrandProd;
use app\models\Carts;
use app\models\Current;
use app\models\ProductImg;
use app\models\Reviews;
use app\models\Dostavka;
use app\models\Category;
use app\models\Wishlist;
use app\models\Engine;
use app\models\Kurs;
use app\models\OrdersShop;
use app\models\OrderItem;
use app\models\ManufacturerAuto;
use app\models\ModelAuto;

use app\models\ValueEngine;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\OrdersForm;
use app\models\ReviewForm;
use app\models\ContactWriteForm;
use app\models\ZakazForm;
use app\models\LoginForm;
use app\models\UpForm;
use app\models\SortForm;
use app\models\SingupForm;
use app\models\AccountForm;
use app\models\CartAddForm;
use app\models\User;
use app\models\Customers;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\Page;
use app\models\AutoForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class AutoshopController extends AppController // \yii\web\Controller
{


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['login', 'signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    //   'login' => ['post'],
                    'signup' => ['post'],
                ],
            ],
        ];
    }

    /*...*/
    /**
     * {@inheritdoc}
     */
    public function actions()
    {

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',

            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function openSession()
    {
        $session = Yii::$app->session;
        $session->open();
        return $session;
    }

    public function setCartDefult()
    {
        $session = $this->openSession();
        if (!$session->has('cart')) {
            $session->set('cart', []);
        }
    }

    public function getCartSession()
    {
        $session = $this->openSession();
        if (!$session->has('cart')) {
            $session->set('cart', []);
            return  [];
        } else {
            return   $session->get('cart');
        }
    }

    public function getWishSession()
    {

        $session = $this->openSession();
        if (!$session->has('wish_auto')) {
            $session->set('wish_auto', []);
            return  [];
        } else {
            return   $session->get('wish_auto');
        }
    }

    public function getSessionLang()
    {
        $session = $this->openSession();
        if (!$session->has('lang')) {
            $lang = ['Id' => 0, 'language' => 'Українська', 'Abb' => 'ua'];
            $session->set('lang', $lang);
        } else {
            $lang = $session->get('lang');
        }
        return $lang;
    }

    public function getSessionCurrent()
    {
        $session = $this->openSession();
        if (!$session->has('current')) {
            $current = ['Id' => 1, 'Name' => 'ГРН', 'Small_name' => '₴'];
            $session->set('current', $current);
        } else {
            $current = $session->get('current');
        }
        return $current;
    }

    public function getSessionCustomer()
    {
        $session = $this->openSession();
        if (!$session->has('customer')) {
            $customer = ['Id' => 1, 'FName' => 'Гість'];
            $session->set('customer', $customer);
        } else {
            $customer = $session->get('customer');
        }
        return  $customer;
    }

    public function getSessionGreeting()
    {
        $session = $this->openSession();
        if (!$session->has('greeting')) {
            $greeting = 'Добрий день';
            $session->set('greeting', $greeting);
        } else {
            $greeting = $session->get('greeting');
        }
        return  $greeting;
    }


    // -----------------------------
    //-------------------------

    public function actionAccount()
    {
        $cur = 1;
        $customer = $this->getSessionCustomer();
        $wishlist = $this->getWishSession();
        $id_cust = $customer['Id'];
        if ($customer['Id'] == 1) {
            return $this->redirect('login');
        }
        $model = new AccountForm();
        $user = Customers::find()->where(['Id' => $id_cust])->one();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {

            if ($model->password != $user->Password) {
                $password = \Yii::$app->security->generatePasswordHash($model->password);
            } else {
                $password = $user->Password;
            }

            // $us = ['Id' => $log->Id, 'FName' => $log->FName];
            Yii::$app->session->set('customer', ['Id' => $customer['Id'], 'FName' => $model->nameuser]);

            \Yii::$app
                ->db
                ->createCommand()
                ->update('customers', ['Login' => $model->login, 'FName' => $model->nameuser, 'LName' => $model->sername, 'Email' => $model->email, 'Phone' => $model->phone, 'Password' => $password,  'News' => $model->news, 'City' => $model->city, 'Adres' => $model->adres], 'Id=' . $id_cust)
                ->execute();
        }

        if ($_GET['add'] == 'add') {
            $id = abs((int) $_GET['id']);
            $product = Products::findOne($id);
            $count = $product->MinQunt;
            $carts = $this->getCartSession();

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
            Yii::$app->session->set('cart', $carts);
        }

        if ($_GET['clear'] == 'clear') {

            Yii::$app->session->set('wish_auto', []);
            \Yii::$app
                ->db
                ->createCommand()
                ->delete('wishlist', ['IdCustomer' => $customer['Id']])
                ->execute();
        }
        if (($_GET['del'] == 'delete')) {
            $id = abs((int) $_GET['id']);
            if (isset($wishlist['products'][$id])) {
                unset($wishlist['products'][$id]);

                \Yii::$app
                    ->db
                    ->createCommand()
                    ->delete('wishlist', ['IdProduct =' . $id, 'IdCustomer =' . $customer['Id']])
                    ->execute();
            }

            Yii::$app->session->set('wish_auto', $wishlist);
        }
        $current = Current::findOne($id = $cur);
        $query = Products::find()->select('Id, Name, Description, Img, Img2, MetaDescription, MetaTitle, MetaKeyword, IdBrand, Id_lang, Id_category, Price, Id_discont, Availability, Id_current, MinQunt')->orderBy('Name DESC')->all();
        $wishlistSesion = $this->getWishSession();
        $countSES = 0;
        if (!empty($wishlistSesion)) {
            foreach ($wishlistSesion['products'] as $ses) {
                $countSES = 1 + $countSES;
            }
        } else {
            $countSES = 0;
        }

        //  $wishlist = [];
        $wishlistBD = Wishlist::find()->select('IdCustomer, IdProduct, Name,Price, MinQunt, DateAdd')->where(['IdCustomer' => $id_cust])->all();
        if (count($wishlistBD) != 0) {
            if ($countSES == 0) {
                $wishlist = [];
                foreach ($wishlistBD as $bd) {
                    $wishlist['products'][$bd['IdProduct']]['Id'] = $bd['IdProduct'];
                    $wishlist['products'][$bd['IdProduct']]['Name'] = $bd['Name'];
                    $wishlist['products'][$bd['IdProduct']]['Price'] = $bd['Price'];
                    $wishlist['products'][$bd['IdProduct']]['MinQunt'] = $bd['MinQunt'];
                }
                Yii::$app->session->set('wish_auto', $wishlist);
            } else {
                // $wishlistSesion =  Yii::$app->session->get('wish_auto');
                $wishlist = [];
                foreach ($wishlistBD as $bd) {
                    $wishlist['products'][$bd['IdProduct']]['Id'] = $bd['IdProduct'];
                    $wishlist['products'][$bd['IdProduct']]['Name'] = $bd['Name'];
                    $wishlist['products'][$bd['IdProduct']]['Price'] = $bd['Price'];
                    $wishlist['products'][$bd['IdProduct']]['MinQunt'] = $bd['MinQunt'];
                }
                foreach ($wishlistBD as $bd) {
                    foreach ($wishlistSesion['products'] as $ses) {
                        if ($bd['IdProduct'] != $ses['Id']) {
                            $wishlist['products'][$ses['Id']]['Id'] = $ses['Id'];
                            $wishlist['products'][$ses['Id']]['Name'] =  $ses['Name'];
                            $wishlist['products'][$ses['Id']]['Price'] =  $ses['Price'];
                            $wishlist['products'][$ses['Id']]['MinQunt'] =  $ses['MinQunt'];
                        }
                    }
                }
                Yii::$app->session->set('wish_auto', $wishlist);
                $countwishlist = count($wishlist['products']);
            }
        } else {
            if (!Yii::$app->session->has('wish_auto')) {
                Yii::$app->session->set('wish_auto', []);
                $wishlist = [];
            } else {
                $wishlist = Yii::$app->session->get('wish_auto');
            }
        }

        if (!$wishlist['products']) {
            $messageWish = 'Ваш список бажань порожній';
        } else {
            $messageWish = '';
        }

        $products = [];
        if (isset($wishlist['products'])) {
            foreach ($wishlist['products'] as $list) {
                foreach ($query as $items) {
                    if ($list['Id'] == $items->Id) {
                        array_push($products, $items);
                    }
                }
            }
        }

        $orderUser = OrdersShop::find()->where(['IdUser' => $id_cust])
            ->orderBy('DateAdd DESC')
            // ->orderBy('OrderNumber ASC')
            ->all();
        $newOrder = OrdersShop::find()->where(['IdUser' => $id_cust, 'Status' => 'new'])->all();
        $paidOreder = OrdersShop::find()->where(['IdUser' => $id_cust, 'Status' => 'paid'])->all(); //оплаченны
        $delivOrder = OrdersShop::find()->where(['IdUser' => $id_cust, 'Status' => 'delivered'])->all(); //доставлен
        $processedOrder = OrdersShop::find()->where(['IdUser' => $id_cust, 'Status' => 'processed'])->all(); //Обработан
        $completedOrder = OrdersShop::find()->where(['IdUser' => $id_cust, 'Status' => 'completed'])->all();

        return $this->render('account', compact(['user', 'model', 'wishlist', 'products', 'messageWish', 'orderUser', 'newOrder', 'paidOreder', 'delivOrder', 'processedOrder', 'completedOrder']));
    }

    public function actionLogin()
    {
        $customer = $this->getSessionCustomer();
        $model = new LoginForm();
        if ($customer['Id'] !== 1) {

            return $this->redirect('account');
        }
        if ($model->load(\Yii::$app->request->post()) && $model->login()) {
            // if ($model->validate()){
            $log = User::findByEmail($model->email);
            // print_r($log);
            // $pass = \Yii::$app->security->generatePasswordHash($model->password);
            // if($log->Password == $model->password){
            if (Yii::$app->getSecurity()->validatePassword($model->password, $log->Password)) {
                Yii::$app->session->set('customer', []);
                $us = ['Id' => $log->Id, 'FName' => $log->FName];

                $customer = Yii::$app->session->set('customer', $us);
                $cartUser = Carts::find()->select('IdProduct, IdCustomer, Name,  Price,  DateAdd, Quanty')->where(['IdCustomer' => $log->Id])->all();
                $cartSes = $this->getCartSession();

                if (count($cartUser) !== 0) {
                    if (!isset($cartSes['products'])) {
                        $cart = [];
                        foreach ($cartUser as $product) {
                            $cart['products'][$product->IdProduct]['Id'] = $product->IdProduct;
                            $cart['products'][$product->IdProduct]['Name'] = $product->Name;
                            $cart['products'][$product->IdProduct]['Price'] = $product->Price;
                            $cart['products'][$product->IdProduct]['Quanty'] = $product->Quanty;
                        }
                        $amount = 0.0;
                        foreach ($cart['products'] as $item) {
                            $amount = $amount + $item['Price'] * $item['Quanty'];
                        }
                        $cart['amount'] = $amount;
                        Yii::$app->session->set('cart', $cart);
                    } else {
                        $cart = [];
                        foreach ($cartUser as $product) {
                            $cart['products'][$product->IdProduct]['Id'] = $product->IdProduct;
                            $cart['products'][$product->IdProduct]['Name'] = $product->Name;
                            $cart['products'][$product->IdProduct]['Price'] = $product->Price;
                            $cart['products'][$product->IdProduct]['Quanty'] = $product->Quanty;
                        }

                        foreach ($cartSes['products'] as $item) {
                            foreach ($cartUser as $product) {
                                if ($product->IdProduct != $item['Id']) {
                                    $cart['products'][$item['Id']]['Id'] = $item['Id'];
                                    $cart['products'][$item['Id']]['Name'] = $item['Name'];
                                    $cart['products'][$item['Id']]['Price'] = $item['Price'];
                                    $cart['products'][$item['Id']]['Quanty'] = $item['Quanty'];
                                } else {
                                    $count = $item['Quanty'] + $product->Quanty;
                                    $cart['products'][$item['Id']]['Quanty'] = $count;
                                }
                            }
                        }

                        $amount = 0.0;
                        foreach ($cart['products'] as $item) {
                            $amount = $amount + $item['Price'] * $item['Quanty'];
                        }
                        $cart['amount'] = $amount;
                        Yii::$app->session->set('cart', $cart);
                    }
                }

                return $this->redirect('account');
                //return $this->render('account');
                //    }else{
                //     return $this->refresh();
                //    }
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSingup()
    {
        $customer = $this->getSessionCustomer();
        if ($customer['Id'] !== 1) {

            return $this->redirect('account');
        }

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SingupForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {

            $user = new User();
            $today = date("Y-m-d");
            $user->Login = $model->login;
            $user->hash = md5(microtime());
            $user->FName = $model->fname;
            $user->LName = $model->lname;
            $user->Email = $model->email;
            $user->Phone = $model->phone;
            $user->City = $model->city;
            $user->News = $model->news;
            if ($model->adres == null) {
                $model->adres = 'Харьков самовывоз';
            }
            $user->Adres = $model->adres;
            $user->IdGruop = 1;
            $user->Password = \Yii::$app->security->generatePasswordHash($model->password);
            //echo '<pre>'; print_r($user); die;
            //$user->save();
            \Yii::$app
                ->db
                ->createCommand()
                ->insert('customers', ['Login' => $user->Login, 'password_reset_token' => $user->hash, 'hash' => $user->hash, 'FName' => $user->FName,   'LName' => $user->LName, 'Email' => $user->Email,  'Phone' => $user->Phone, 'News' => $user->News, 'City' => $user->City, 'Adres' => $user->Adres, 'IdGruop' => $user->IdGruop, 'Password' => $user->Password, 'Status' => 10, 'DateRegistration' => $today])
                ->execute();
            // if ($user->save()) {
            Yii::$app->session->set('customer', []);
            $c = User::findByUsername($user->Login);
            $customer = ['Id' => $c['Id'], 'FName' => $user->FName];
            Yii::$app->session->set('customer', $customer);
            return $this->goHome();
            // }
        }
        // if ($model->load(Yii::$app->request->post()) && $model->login()) {
        //     return $this->goBack();
        // }

        // $model->password = '';
        return $this->render('singup', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionExit()
    {
        $customer = $this->getSessionCustomer();
        if ($customer['Id'] == 1) {
            return $this->redirect('index');
        }
        $wishlist = $this->getWishSession();
        $wishlistBD = Wishlist::find()->select('IdCustomer, IdProduct, DateAdd, Name, Price, MinQunt')->where(['IdCustomer' => $customer['Id']])->all();
        $countSES = 0;
        if (isset($wishlist['products'])) {
            foreach ($wishlist['products'] as $ses) {
                ++$countSES;
            }
        } else {
            $countSES = 0;
        }

        if (count($wishlistBD) != 0) { //список желаний из бд не пустой
            if ($countSES == 0) { //спиcок желаний из сесии пуст
                //удаляем все из бд
                \Yii::$app
                    ->db
                    ->createCommand()
                    ->delete('wishlist', 'IdCustomer =' . $customer['Id'])
                    ->execute();
                Yii::$app->session->set('wish_auto', []);
            } else { //список желаний из сесии не пуст 
                // foreach ($wishlistBD as $bd) {
                foreach ($wishlist['products'] as $ses) {
                    $today = date("Y-m-d");
                    $wish = Wishlist::find()->select('IdCustomer, IdProduct, DateAdd, Name, Price, MinQunt')->where(['IdCustomer' => $customer['Id'], 'IdProduct' => $ses['Id']])->all();
                    if (count($wish) == 0) {
                        //$bd['IdProduct'] == $ses['Id']) {
                        //     continue ;
                        // }
                        // else{
                        \Yii::$app
                            ->db
                            ->createCommand()
                            ->insert('wishlist', ['IdProduct' => $ses['Id'], 'IdCustomer' => $customer['Id'], 'Name' => $ses['Name'], 'Price' => $ses['Price'], 'MinQunt' => $ses['MinQunt'], 'DateAdd' => $today])
                            ->execute();
                    }
                }
                // }
                Yii::$app->session->set('wish_auto', []);
            }
        } else { //список желаний из бд пустой

            if ($countSES != 0) { //спиcок желаний из сесии не пуст 
                foreach ($wishlist['products'] as $ses) {
                    $today = date("Y-m-d");
                    \Yii::$app
                        ->db
                        ->createCommand()
                        ->insert('wishlist', ['IdProduct' => $ses['Id'], 'IdCustomer' => $customer['Id'], 'Name' => $ses['Name'], 'Price' => $ses['Price'], 'MinQunt' => $ses['MinQunt'], 'DateAdd' => $today])
                        ->execute();
                }
                Yii::$app->session->set('wish_auto', []);
            }
        }

        $cartSes = $this->getCartSession();;
        $countCart = 0;
        if (isset($cartSes['products'])) {
            foreach ($cartSes['products'] as $ses) {
                ++$countCart;
            }
        } else {
            $countCart = 0;
        }
        $cartBd = Carts::find()->select('IdProduct, IdCustomer, Name,  Price,  DateAdd, Quanty')->where(['IdCustomer' => $customer['Id']])->all();
        if (count($cartBd) != 0) { //корзина из бд не пустой
            if ($countCart == 0) { //корзина из сесии пуст
                //удаляем все из бд
                \Yii::$app
                    ->db
                    ->createCommand()
                    ->delete('carts', ['IdCustomer' => $customer['Id']])
                    ->execute();
                Yii::$app->session->set('cart', []);
            } else { //корзина из сесии не пустa 

                foreach ($cartSes['products'] as $ses) {
                    $today = date("Y-m-d");
                    $cartItem = Carts::find()
                        //->select('IdProduct, IdCustomer, Name,  Price,  DateAdd, Quanty')
                        ->where(['IdCustomer' => $customer['Id'], 'IdProduct' => $ses['Id']])->all();
                    if (count($cartItem) == 0) {
                        //$bd['IdProduct'] == $ses['Id']) {
                        //     continue ;
                        // }
                        // else{
                        \Yii::$app
                            ->db
                            ->createCommand()
                            ->insert('carts', ['IdProduct' => $ses['Id'], 'IdCustomer' => $customer['Id'], 'Name' => $ses['Name'], 'Price' => $ses['Price'], 'Quanty' => $ses['Quanty'], 'DateAdd' => $today])
                            ->execute();
                    }
                }
                Yii::$app->session->set('cart', []);
            }
        } else { //корзина из бд пустой

            if ($countCart != 0) { //корзина из сесии не пуст 
                foreach ($cartSes['products'] as $ses) {
                    $today = date("Y-m-d");
                    \Yii::$app
                        ->db
                        ->createCommand()
                        ->insert('carts', ['IdProduct' => $ses['Id'], 'IdCustomer' => $customer['Id'], 'Name' => $ses['Name'], 'Price' => $ses['Price'], 'Quanty' => $ses['Quanty'], 'DateAdd' => $today])
                        ->execute();
                }
                Yii::$app->session->set('cart', []);
            }
        }

        Yii::$app->session->remove('customer');
        $customer = ['Id' => 1, 'FName' => 'Гість'];
        Yii::$app->session->set('customer', $customer);
        Yii::$app->session->set('wish_auto', []);
        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Перевірте свою електронну пошту для подальших інструкцій.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'На жаль, ми не можемо скинути пароль для вказаної адреси електронної пошти.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Новий пароль збережено.');
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


    // хэш значение $sess = md5(microtime())

    public function actionConfirmation()
    {


        $greeting = $this->getSessionGreeting();
        $lang = $this->getSessionLang();

        $this->setMetaTags();

        $person = Yii::$app->session->get('person');
        $name = $person['name'];
        $lastname = $person['lastname'];
        $email = $person['email'];
        if (empty($person)) {
            return $this->goHome();
        }

        Yii::$app->session->set('cart', []);
        Yii::$app->session->set('person', []);

        return $this->render('confirmation', compact('email', 'name', 'lastname'));
    }

    public function actionActia()
    {
        $this->setMetaTags();
        $actions = Actions::find()->orderBy('DateAdd DESC')->all();

        return $this->render('actia', ['actions' => $actions]);
    }


    public function actionOrder()
    {
        $session = Yii::$app->session;
        $session->open();
        $person = $session->get('person');
        $greeting = $this->getSessionGreeting();
        $customer = $this->getSessionCustomer();
        $wishlist = $this->getWishSession();
        $lang = $this->getSessionLang();
        $current = $this->getSessionCurrent();

        $this->setMetaTags();
        $cur =  $current['Id'];
        $carts = $this->getCartSession();
        // $current = Current::findOne($cur);
        if ($carts['amount'] == 0) {
            Yii::$app->session->setFlash(
                'warning',
                'Ваш кошик порожній!'
            );
            return  $this->redirect(['index']);
        }

        $order_form = new OrdersForm();

        if (\Yii::$app->request->isAjax) {
            if ($_GET['data']) {
                $id = ($_GET['data']);
                $option = '';

                if ($id == 1) {
                    $option = 'Харків';
                    '<label class="control-label" for="shipingCity">Город доставки</label>
                    // <input type="text" id="shipingCity" class="form-control" name="OrdersForm[shipingCity]" value="Харків" readonly>';
                } else {
                    $option = '';
                }
                return $option;
            }

            if ($_GET['city']) {
                $city = ($_GET['city']);
                $option = '';

                if ($city == 'Харьков' || $city == 'Харків') {
                    return    $option = 'Авторинок Автоград, пр. Л.Ландау 2-б, 4 ряд 31 магазин';
                } else {
                    return  $option = '';
                }
            }
        }

        if ($order_form->load(\Yii::$app->request->post())) {
            $today = date("Y-m-d H:i:s"); // (формат MySQL DATETIME)
            if ($order_form->validate()) {
                $orderShop = OrdersShop::find()->select('Id, OrderNumber, IdUser, Name, LastName, Email, Phone, City, IdDostavka, Comment, Amount, Status, DateAdd, IdOplata, Mailing')->all();
                $num = count($orderShop);
                if ($num == 0) {
                    $num = 1;
                } else {
                    $num++;
                }

                $mailing = $order_form['mailing'];
                $name = $order_form['name'];
                $adress = $order_form['adress'];
                $lastname = $order_form['lastname'];
                $email = $order_form['email'];
                $phone = $order_form['phone'];
                $note = $order_form['note'];
                $shiping = $order_form['shiping'];
                $shipingCity = $order_form['shipingCity'];
                $adress = $order_form['adress'];
                $cash = $order_form['cash'];
                $idOrder = $num . '-' . date("Y-m-d");
                $mailing = $order_form['mailing'];
                $amount = $carts['amount'];
                if (!empty($carts['products'])) {
                    foreach ($carts['products'] as $cart) {
                        $itemNal = Products::findOne($cart['Id']);
                        $brandItem = BrandProd::findOne($itemNal->IdBrand);

                        \Yii::$app
                            ->db
                            ->createCommand()
                            ->insert('order_item', ['IdOrder' => $idOrder, 'IdProduct' => $cart['Id'], 'Name' => $cart['Name'], 'Price' => $cart['Price'], 'Quanty' => $cart['Quanty'], 'Cost' => $cart['Price'] * $cart['Quanty'], 'Availability' => 'в наявності', 'Supplier' => 'автоконтакт', 'Brand' => $brandItem->Brand])
                            ->execute();
                    }
                }
                if (!empty($carts['zakaz'])) {
                    foreach ($carts['zakaz'] as $cart) {
                        $z = ZakazProducts::findOne($cart['Id']);
                        \Yii::$app
                            ->db
                            ->createCommand()
                            ->insert('order_item', ['IdOrder' => $idOrder, 'IdProduct' => $cart['Id'], 'Name' => $cart['ProductName'], 'Price' => $cart['Price'], 'Quanty' => $cart['Quanty'], 'Cost' => $cart['Price'] * $cart['Quanty'], 'Availability' => $z->TermsDelive, 'Supplier' => $z->Supplier, 'Brand' => $z->Brand])
                            ->execute();
                    }
                }
                \Yii::$app
                    ->db
                    ->createCommand()
                    ->insert('orders_shop', ['OrderNumber' => $idOrder, 'Adress' => $adress, 'IdUser' => 1, 'Name' => $name, 'LastName' => $lastname, 'Email' => $email, 'Phone' => $phone, 'City' => $shipingCity, 'IdDostavka' => $shiping, 'Comment' => $note, 'Amount' => $amount, 'DateAdd' => $today, 'IdOplata' => $cash, 'Mailing' => $mailing])
                    ->execute();

                $person = [];
                $person['name'] = $name;
                $person['lastname'] = $lastname;
                $person['email'] = $email;
                $person['numorder'] = $idOrder;
                $person['phone'] = $phone;
                $person['adress'] = $shipingCity . ', ' . $adress;
                $dost = Dostavka::find()->select('Name')->where(['Id' => $shiping])->one();;
                $person['dostavka'] = $dost->Name;
                $person['note'] = $note;
                $session->set('person', $person);
                // отправляем письмо покупателю
                $order = $carts;
                //var_dump($carts);
                Yii::$app->mailer->compose(
                    'views/order',
                    [
                        'order' => $order,
                        'person' => $person

                    ]
                )
                    ->setFrom(Yii::$app->params['senderEmail'])
                    ->setTo($email)
                    ->setSubject('Заказ № ' . $person['numorder'])
                    ->send();
                Yii::$app->mailer->compose()
                    ->setFrom(Yii::$app->params['adminEmail'])
                    ->setTo(Yii::$app->params['senderEmail'])
                    ->setSubject('Заказ № ' . $person['numorder'])
                    ->setTextBody('Пришел новый заказ')
                    ->send();

                $this->refresh();
                return  $this->redirect(['confirmation']);
            } else {

                $errors = $order_form->errors;
            }
        }

        return $this->render('order', compact('current', 'carts', 'order_form', 'shiping', 'customer'));
    }

    public function actionCart()
    {
        $greeting = $this->getSessionGreeting();
        $customer = $this->getSessionCustomer();
        $wishlist = $this->getWishSession();
        $lang = $this->getSessionLang();
        $current = $this->getSessionCurrent();

        $this->setMetaTags();

        $carts = $this->getCartSession();
        $Quanty = 1;
        $idCustom = $customer['Id'];
        $idses = 1;
        $cur = $current['Id'];
        $messageCart = '';
        if (($_GET['del'] == 'delete')) {

            $id = abs((int) $_GET['id']);

            $carts = $this->getCartSession();

            if (isset($carts['products'][$id])) {
                unset($carts['products'][$id]);
                if ($customer['Id'] != 1) {
                    $cartItem = Carts::find()
                        ->select('IdProduct, IdCustomer, Name,  Price,  DateAdd, Quanty')
                        ->where(['IdCustomer' => $customer['Id'], 'IdProduct' => $id])
                        ->all();
                    if ($cartItem != null) {
                        \Yii::$app
                            ->db
                            ->createCommand()
                            ->delete('carts', ['IdCustomer' => $customer['Id'], 'IdProduct' => $id])
                            ->execute();
                    }
                }
            }

            $amount = 0.0;
            if (!empty($carts['products'])) {
                foreach ($carts['products'] as $item) {
                    $amount = $amount + $item['Price'] * $item['Quanty'];
                }
            }
            if (!empty($carts['zakaz'])) {
                foreach ($carts['zakaz'] as $item) {
                    $amount = $amount + $item['Price'] * $item['Quanty'];
                }
            }
            $carts['amount'] = $amount;

            Yii::$app->session->set('cart', $carts);
        }
        if (($_GET['delZakaz'] == 'delete')) {

            $id = abs((int) $_GET['id']);
            $Supplier = $_GET['Supplier'];
            $Brand = $_GET['Brand'];
            $carts = $this->getCartSession();

            if (isset($carts['zakaz'][$id])) { {
                    unset($carts['zakaz'][$id]);
                }
            }

            $amount = 0.0;
            foreach ($carts['products'] as $item) {
                $amount = $amount + $item['Price'] * $item['Quanty'];
            }
            foreach ($carts['zakaz'] as $item) {
                $amount = $amount + $item['Price'] * $item['Quanty'];
            }

            $carts['amount'] = $amount;

            Yii::$app->session->set('cart', $carts);
        }
        if ($_GET['clear'] == 'yes') {
            $session = Yii::$app->session;
            $session->open();
            $session->set('cart', []);
            if ($customer['Id'] != 1) {
                \Yii::$app
                    ->db
                    ->createCommand()
                    ->delete('carts', ['IdCustomer' => $customer['Id']])
                    ->execute();
            }
            $this->redirect(Yii::$app->request->referrer);
        }


        $up_form = new UpForm();
        if ($up_form->load(\Yii::$app->request->post())) {
            // (формат MySQL DATETIME)
            if ($up_form->validate()) {
                $carts = $this->getCartSession();
                if (!empty($up_form['idB'])) {
                    $idB = $up_form['idB'];
                    $item = Products::findOne($idB);
                    $quanty = $up_form['quanty'];
                    if ($quanty < $item->MinQunt) {
                        $quanty = $item->MinQunt;
                    }
                    $carts['products'][$idB]['Quanty'] = $quanty;
                }
                if (!empty($up_form['idz'])) {
                    $idz = $up_form['idz'];
                    $item = ZakazProducts::findOne($idz);
                    $quanty = $up_form['quanty'];
                    if ($quanty == 0) {
                        unset($carts['zakaz'][$idz]);
                    }
                    $carts['zakaz'][$idz]['Quanty'] = $quanty;
                }

                $amount = 0.0;
                foreach ($carts['products'] as $item) {
                    $amount = $amount + $item['Price'] * $item['Quanty'];
                }
                foreach ($carts['zakaz'] as $item) {
                    $amount = $amount + $item['Price'] * $item['Quanty'];
                }
                $carts['amount'] = $amount;

                Yii::$app->session->set('cart', $carts);
            }
        }


        return $this->render('cart', compact('cartProduct', 'current', 'carts', 'Quanty', 'up_form'));
    }

    public function actionContactform()
    {

        $this->setMetaTags();
        $model = new ContactWriteForm();
        $today = date("Y-m-d H:i:s");
        /*
         * Если пришли post-данные, загружаем их в модель...
         */
        if ($model->load(Yii::$app->request->post())) {
            // ...и проверяем эти данные
            if (!$model->validate()) {
                /*
                 * Данные не прошли валидацию
                 */
                Yii::$app->session->setFlash(
                    'feedback-success',
                    false
                );
                // сохраняем в сессии введенные пользователем данные
                Yii::$app->session->setFlash(
                    'feedback-data',
                    [
                        'name' => $model->name,
                        'email' => $model->email,
                        'body' => $model->body,
                        'subject' => $model->subject
                    ]
                );
                /*
                 * Сохраняем в сессии массив сообщений об ошибках. Массив имеет вид
                 * [
                 *     'name' => [
                 *         'Поле «Ваше имя» обязательно для заполнения',
                 *     ],
                 *     'email' => [
                 *         'Поле «Ваш email» обязательно для заполнения',
                 *         'Поле «Ваш email» должно быть адресом почты'
                 *     ]
                 * ]
                 */
                Yii::$app->session->setFlash(
                    'feedback-errors',
                    $model->getErrors()
                );
            } else {
                \Yii::$app
                    ->db
                    ->createCommand()
                    ->insert('mail_contact', ['FIO' => $model->name, 'TitleMessage' => $model->subject, 'Message' => $model->body, 'Email' => $model->email, 'Status' => 'new', 'DateAdd' => $today])
                    ->execute();
                /*
                 * Данные прошли валидацию
                 */

                // отправляем письмо на почту администратора

                $textBody = 'Имя: ' . strip_tags($model->name) . PHP_EOL;
                $textBody .= 'Почта: ' . strip_tags($model->email) . PHP_EOL . PHP_EOL;
                $textBody .= 'Дата отправки: ' . strip_tags($today) . PHP_EOL;
                $textBody .= 'Тема сообщения: ' . strip_tags($model->subject) . PHP_EOL . PHP_EOL;
                $textBody .= 'Сообщение: ' . PHP_EOL . strip_tags($model->body);

                $htmlBody = '<p><b>Имя</b>: ' . strip_tags($model->name) . '</p>';
                $htmlBody .= '<p><b>Почта</b>: ' . strip_tags($model->email) . '</p>';
                $htmlBody .= 'Дата отправки: ' . strip_tags($today) . '</p>';
                $htmlBody .= '<p><b>Тема сообщения</b>: ' . strip_tags($model->subject) . '</p>';
                $htmlBody .= '<p><b>Сообщение</b>:</p>';
                $htmlBody .= '<p>' . nl2br(strip_tags($model->body)) . '</p>';

                Yii::$app->mailer->compose()
                    ->setFrom(Yii::$app->params['senderEmail'])
                    ->setTo(Yii::$app->params['adminEmail'])
                    ->setSubject('Заполнена форма обратной связи')
                    ->setTextBody($textBody)
                    ->setHtmlBody($htmlBody)
                    ->send();

                // данные прошли валидацию, отмечаем этот факт
                // Yii::$app->session->setFlash(
                //     'feedback-success',
                //     true
                // );
                Yii::$app->session->setFlash('success', 'Ваше замовлення прийнято успішно, чекайте на дзвінок менеджера.');
            }
            // выполняем редирект, чтобы избежать повторной отправки формы
            return $this->refresh();
        }
        return $this->render('contactform', ['model' => $model]);
    }

    public function actionContact()
    {
        $greeting = $this->getSessionGreeting();
        $customer = $this->getSessionCustomer();
        $wishlist = $this->getWishSession();
        $lang = $this->getSessionLang();
        $current = $this->getSessionCurrent();

        $this->setMetaTags();


        $store = Store::find()->select(' Id, Name_shop,  Description, Meta_title, Meta_description, Meta_keyword, Phone, Viber, Facebook_link , Work_time, Email, Adress,Owner, Telegram_link, Google_map, Logo, logo_small, Id_lang, Description_ua, 	Meta_title_ua, Meta_description_ua, Meta_keyword_ua, Work_time_ua, Adress_ua')->where(['Id' => 1])->one();
        return $this->render('contact', compact('store', 'lang'));
    }


    public function actionIndex()
    {
        $model = new AutoForm();
        $session = $this->openSession();
        $session->remove('store');
        $this->getSessionGreeting();
        $this->getSessionCustomer();
        $this->getWishSession();
        $this->getSessionLang();
        $this->getSessionCurrent();
        if (!$session->has('cart')) {
            $session->set('cart', []);
        }

        $session->set('person', []);
        // $this->setMetaTags();

        if ($session->has('store')) {
            $store = $session->get('store');
        } else {
            $store = Store::find()->select('Id, Name_shop,  Description, Meta_title, Meta_description, Meta_keyword, Phone, Viber,Facebook_link, Adress, Telegram_link, Logo, logo_small, Description_ua, Meta_title_ua, Meta_description_ua, Meta_keyword_ua, Work_time_ua, Info, Adress_ua')->where(['Id' => 1])->one();
            $session->set('store', [
                'Name_shop' => $store->Name_shop,
                'Meta_title' => $store->Meta_title,
                'Meta_description' => $store->Meta_description,
                'Meta_keyword' => $store->Meta_description,
                'Phone' => $store->Phone,
                'Viber' => $store->Viber,
                'Facebook_link' => $store->Facebook_link, 'Adress' => $store->Adress,
                'Telegram_link' => $store->Telegram_link,
                'Logo' => $store->Logo,
                'logo_small' => $store->logo_small, 'Description_ua' => $store->Description_ua,
                'Meta_title_ua' => $store->Meta_title_ua, 'Meta_description_ua' => $store->Meta_description_ua, 'Meta_keyword_ua' => $store->Meta_keyword_ua,
                'Work_time_ua' => $store->Work_time_ua,
                'Info' => $store->Info, 'Adress_ua' => $store->Adress_ua
            ]);
        }

        if (
            $model->load(Yii::$app->request->post())
            && $model->validate() && $model->model != 0 && $model->modification != 0
        ) {
            $marka = $model->marka;
            $models = $model['model'];
            $modification = $model['modification'];
            return $this->redirect(['autocatalog/index', 'marka' => $marka, 'models' => $models, 'modification' => $modification]);
        }

        $this->setMetaTags();

        return $this->render(
            'index',
            [
                'model' => $model
            ]
        );
    }



    public function actionList($idCat = '', $nameCategory = 'Весь товар', $idBrand = '', $sorttext = ' DateAdd DESC')
    {
        //используем сессии
        $greeting = $this->getSessionGreeting();
        $customer = $this->getSessionCustomer();
        $wishlist = $this->getWishSession();
        $lang = $this->getSessionLang();
        $current = $this->getSessionCurrent();

        $kurs = Kurs::find()->where(['Id' => 1])->one();

        $wishlist = $this->getWishSession();
        $carts = $this->getCartSession();


        if ($_GET['addCart'] == 'add') {

            $count = (int) $_GET['count'];
            if ($count < 1) {
                return;
            }
            $id = abs((int) $_GET['id']);
            $product = Products::findOne($id);
            if (empty($product)) {
                return;
            }
            if ($count < $product->MinQunt) {
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
            if (!empty($carts['products'])) {
                foreach ($carts['products'] as $item) {
                    $amount = $amount + $item['Price'] * $item['Quanty'];
                }
            }
            if (!empty($carts['zakaz'])) {
                foreach ($carts['zakaz'] as $items) {
                    $amount = $amount + $items['Price'] * $items['Quanty'];
                }
            }
            $carts['amount'] = $amount;
            Yii::$app->session->set('cart', $carts);
            $this->redirect(Yii::$app->request->referrer);
        }
        if ($_GET['addZakaz'] == 'add') {

            $id = abs((int) $_GET['id']);
            $product = ZakazProducts::findOne($id);
            $kurs = Kurs::findOne(1);
            if (!empty($product)) {

                $count = 1;
            }


            if (isset($carts['zakaz'][$product->Id])) { // такой товар уже есть?
                $count = $carts['zakaz'][$product->Id]['Quanty'] + $count;

                if ($count > 100) {
                    $count = 100;
                }
                $carts['zakaz'][$product->Id]['Quanty'] = $count;
            } else { // такого товара еще нет
                $carts['zakaz'][$product->Id]['Id'] = $product->Id;
                $carts['zakaz'][$product->Id]['ProductName'] = $product->ProductName;
                $carts['zakaz'][$product->Id]['Price'] = round($product->EntryPrice * (1 + $product->Markup * 0.01) * $kurs->Current_kurs);
                $carts['zakaz'][$product->Id]['Quanty'] = $count;
                //$carts['zakaz'][$product->Id]['TermsDelive']=$product->TermsDelive;
                $carts['zakaz'][$product->Id]['Supplier'] = $product->Supplier;
                $carts['zakaz'][$product->Id]['Brand'] = $product->Brand;
            }
            $amount = 0.0;
            if (!empty($carts['products'])) {
                foreach ($carts['products'] as $item) {
                    $amount = $amount + $item['Price'] * $item['Quanty'];
                }
            }
            if (!empty($carts['zakaz'])) {
                foreach ($carts['zakaz'] as $items) {
                    $amount = $amount + $items['Price'] * $items['Quanty'];
                }
            }
            $carts['amount'] = $amount;
            Yii::$app->session->set('cart', $carts);
            $this->redirect(Yii::$app->request->referrer);
        }

        if ($_GET['delCart'] == 'del') {
            $id = abs((int) $_GET['id']);

            $carts = $this->getCartSession();

            if (isset($carts['products'][$id])) {
                unset($carts['products'][$id]);
                if ($customer['Id'] != 1) {
                    $cartItem = Carts::find()
                        ->select('IdProduct, IdCustomer, Name,  Price,  DateAdd, Quanty')
                        ->where(['IdCustomer' => $customer['Id'], 'IdProduct' => $id])
                        ->all();
                    if ($cartItem != null) {
                        \Yii::$app
                            ->db
                            ->createCommand()
                            ->delete('carts', ['IdCustomer' => $customer['Id'], 'IdProduct' => $id])
                            ->execute();
                    }
                }
            }

            if (count($carts['products']) == 0) {
                Yii::$app->session->set('cart', []);
            }
            $amount = 0.0;
            foreach ($carts['products'] as $item) {
                $amount = $amount + $item['Price'] * $item['Quanty'];
            }

            $carts['amount'] = $amount;

            Yii::$app->session->set('cart', $carts);
            $this->redirect(Yii::$app->request->referrer);
        }
        if ($_GET['delZakaz'] == 'del') {
            $id = abs((int) $_GET['id']);
            $carts = $this->getCartSession();

            if (isset($carts['zakaz'][$id])) {
                unset($carts['zakaz'][$id]);
            }


            $amount = 0.0;
            foreach ($carts['products'] as $item) {
                $amount = $amount + $item['Price'] * $item['Quanty'];
            }
            foreach ($carts['zakaz'] as $items) {
                $amount = $amount + $items['Price'] * $items['Quanty'];
            }
            $carts['amount'] = $amount;

            Yii::$app->session->set('cart', $carts);
            $this->redirect(Yii::$app->request->referrer);
        }

        if (($_GET['wish'] == 'add')) {

            $wishlist = $this->getWishSession();
            $id = abs((int) $_GET['id']);
            $product = Products::findOne($id);
            if (empty($product)) {
                throw new \yii\web\HttpException(404, 'Такого товару немає');
            }

            if (isset($wishlist['products'][$product->Id])) { // такой товар уже есть?
                throw new \yii\web\HttpException(404, 'Цей товар вже додано до списку бажань');
            } else { // такого товара еще нет
                $wishlist['products'][$product->Id]['Id'] = $product->Id;
                $wishlist['products'][$product->Id]['Name'] = $product->Name;
                $wishlist['products'][$product->Id]['Price'] = $product->Price;
                $wishlist['products'][$product->Id]['MinQunt'] = $product->MinQunt;
            }

            Yii::$app->session->set('wish_auto', $wishlist);
            $this->redirect(Yii::$app->request->referrer);
        }


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

        $modelSort = new SortForm();



        if ($_GET['sort'] == 1) {
            $sorttext = ' DateAdd DESC';
        } elseif ($_GET['sort'] == 2) {
            $sorttext = 'Price DESC';
        } elseif ($_GET['sort'] == 3) {
            $sorttext = 'Price ASC';
        } else {
            $sorttext = 'Name ASC';
        }

        if ($idBrand != '') {
            $pageSize = 4;
            $query = Products::find()
                ->where(['IdBrand' => $idBrand, 'Status' => 10]);
        }

        if ($idCat == '' & $idBrand == '') {
            $pageSize = 4;
            $query = Products::find()
                ->where(['Status' => 10]);
        }

        if ($idCat != '') {
            $ids = Category::getAllChildIds($idCat);
            $ids[] = $id;
            if (count($ids) == 1) {
                $query = Products::find()
                    ->where(['in', 'Id_category', $idCat])->AndWhere(['Status' => 10]);
            } else {
                $query = Products::find()

                    ->where(['in', 'Id_category', $ids])
                    ->AndWhere(['Status' => 10]);
            }
        }
        $pages = new \yii\data\Pagination([
            'totalCount' => $query->count(),
            'pageSize' => Yii::$app->params['pageSize'], //$pageSize, //колличество товаров на странице
            'pageSizeParam' => false,
            'forcePageParam' => false
        ]);

        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            // Получаем данные модели из запроса
            if ($data == 1) {
                $sorttext = ' DateAdd DESC';
            } elseif ($data == 2) {
                $sorttext = 'Price DESC';
            } elseif ($data == 3) {
                $sorttext = 'Price ASC';
            } else {
                $sorttext = 'Name ASC';
                $prods = $query->offset($pages->offset)->limit($pages->limit)->orderBy($sorttext)->all();
            }


            $error = "error2";
        }

        $prods = $query->offset($pages->offset)->limit($pages->limit)->orderBy($sorttext)->all();

        return $this->render('list', compact('nameCategory', 'prods', 'pages', 'idCat', 'current', 'wishlist', 'modelSort', 'query', 'error', 'kurs'));
    }




    public function actionView()
    {

        $kurs = Kurs::find()->where(['Id' => 1])->one();
        $page = Yii::$app->params['pageSize'];
        $greeting = $this->getSessionGreeting();
        $customer = $this->getSessionCustomer();
        $wishlist = $this->getWishSession();
        $lang = $this->getSessionLang();
        $current = $this->getSessionCurrent();
        $carts = $this->getCartSession();

        // $this->setMetaTags();
        $message = '';

        $idCustom = $customer['Id'];
        $id = Yii::$app->request->get('id');
        $item = Products::findOne($id);
        if (empty($item)) throw new \yii\web\HttpException(404, 'Такої сторінки немає...');


        if (($_GET['wish'] == 'add')) {

            $wishlist = $this->getWishSession();

            if (!isset($wishlist['products'][$item->Id]))
            // {
            //     return;

            // } else
            {
                $wishlist['products'][$item->Id]['Id'] = $item->Id;
                $wishlist['products'][$item->Id]['Name'] = $item->Name;
                $wishlist['products'][$item->Id]['Price'] = $item->Price;
                $wishlist['products'][$item->Id]['MinQunt'] = $item->MinQunt;
            }

            Yii::$app->session->set('wish_auto', $wishlist);
        }

        if (($_GET['wish'] == 'del')) {  //  $id = abs((int) $_GET['id']);

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
        }

        $brend = BrandProd::findOne($id = $item->IdBrand);
        // $current = Current::findOne($id = $item->Id_current);
        $img = $item->productImgs;
        //  $img = ProductImg::find()->select('Id', 'IdProduct', 'Img')->where(['IdProduct' => $item->Id])->asArray()->all();
        $reviews = Reviews::find()->select('Id, Id_Costome, IdProduct, Title, Review, Raiting, Date_add, Name')->where(['IdProduct' => $item->Id])->orderBy('Date_add DESC')->all();
        $star = 0;
        foreach ($reviews as $rew) {
            $star += $rew->Raiting;
        }
        $countRew = count($reviews);
        if ($countRew) {
            $stars = round($star / $countRew);

            $stars = round($stars);
        } else {
            $star = 0;
        }
        $form_review = new ReviewForm();

        if ($form_review->load(\Yii::$app->request->post())) {
            $today = date("Y-m-d"); // (формат MySQL DATETIME)
            if ($form_review->validate()) {
                $nameCustom = $form_review['name'];
                $titleReview = $form_review['title'];
                $raitingReview = $form_review['raiting'];
                $reviewDescr = $form_review['review'];
                \Yii::$app
                    ->db
                    ->createCommand()
                    ->insert('reviews', ['IdProduct' => $item->Id, 'Id_Costome' => $customer['Id'], 'Title' => $titleReview, 'Name' => $nameCustom, 'Review' => $reviewDescr, 'Raiting' => $raitingReview, 'Date_add' => $today])
                    ->execute();
                $this->refresh();
            } else {

                $errors = $form_review->errors;
                echo $errors;
            }
        }
        $form_quant = new CartAddForm();

        if ($form_quant->load(\Yii::$app->request->post())) {

            if ($form_quant->validate()) {
                $count  = $form_quant['quant'];
                $idCustom = $customer['Id'];
                $idses = 1;
                $today = date("Y-m-d"); // (формат MySQL DATETIME) 


                if ($count < 1) {
                    return;
                }
                $product = $item;
                if (empty($product)) {
                    return;
                }
                if ($count < $product->MinQunt) {
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
                    $amount = $amount + ($item['Price'] * $item['Quanty']);
                }
                $carts['amount'] = $amount;

                Yii::$app->session->set('cart', $carts);
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);

                // $this->refresh();
            }
        }
        $query = $item->Name . ',' . $item->Tegs;

        $zakaz_products = [];
        list($analogs, $pages) = (new Products())->getSearchAnalogResult($item->Tegs, $page);

        list($zakaz_products, $pagesZ) = (new ZakazProducts())->getSearchResult($query, $page);

        return $this->render('view', compact(
            'item',
            'brend',
            'current',
            'img',
            'reviews',
            'countRew',
            'stars',
            'form_review',
            'form_quant',
            'carts',
            'message',
            'analogs',
            'pages',
            'pagesZ',
            'zakaz_products',
            'kurs'
        ));
    }


    public function actionZakaz()
    {

        $greeting = $this->getSessionGreeting();
        $customer = $this->getSessionCustomer();
        $wishlist = $this->getWishSession();
        $lang = $this->getSessionLang();
        $current = $this->getSessionCurrent();
        $carts = $this->getCartSession();

        $this->setMetaTags();
        $Id_lang = $lang['Id'];
        $arrmod = [];

        if (\Yii::$app->request->isAjax) {
            $id = ($_GET['data']);
            $option = '';
            $modelsAuto =  ModelAuto::find()->select(['ModelName', 'Id'])
                ->where(['IdManufacturer' => $id])
                ->orderBy('ModelName')
                ->all();

            if (count($modelsAuto) > 0) {
                foreach ($modelsAuto as $modelAuto) {
                    $option .= '<option value="' . $modelAuto->Id . '">' . $modelAuto->ModelName . '</option>';
                }
            } else {
                $option = '<option>-</option>';
            }

            return $option; // 'Запрос принят!'.$_GET['data'];

        }


        $zakaz_form = new ZakazForm();
        $markaArr =  ManufacturerAuto::find()->select(['Marka', 'Id'])->indexBy('Id')->orderBy('Marka ASC')->column();
        //  $arrmod = ModelAuto::find()->select(['ModelName', 'Id'])->where(['IdManufacturer' => $zakaz_form['marka']])->indexBy('Id')->orderBy('ModelName ASC')->column();
        $arrinterv = ModelAuto::find()->select(['constructioninterval', 'ModelName', 'IdManufacturer', 'Id'])->orderBy('ModelName ASC')->all();

        if ($zakaz_form->load(\Yii::$app->request->post())) {
            $today = date("Y-m-d H:i:s"); // (формат MySQL DATETIME)
            if ($zakaz_form->validate()) {
                $engenie =  Engine::find()->select(['Name', 'Id', 'Id_lang'])->where(['Id_lang' => $Id_lang, 'Id' => $zakaz_form['eng']])->one();
                $volum = ValueEngine::find()->select(['Value', 'Id'])->where(['Id' => $zakaz_form['volume']])->one();
                $m = ManufacturerAuto::find()->select(['Marka', 'Id'])->where(['Id' => $zakaz_form['marka']])->one();
                $marka = $m->Marka;
                if ($zakaz_form['model'] == '-') {
                    $model = '-';
                } else {
                    $mod = ModelAuto::find()->select(['IdManufacturer', 'ModelName', 'constructioninterval', 'Id'])->where(['Id' => $zakaz_form['model']])->one();
                    $model = $mod->ModelName;
                }

                $years = $zakaz_form['years'];
                $valueen = $volum->Value . ' ' . $engenie->Name;
                $vin = $zakaz_form['vin'];
                $description = $zakaz_form['description'];
                $fio = $zakaz_form['fio'];
                $email = $zakaz_form['email'];
                $phone = $zakaz_form['phone'];
                \Yii::$app
                    ->db
                    ->createCommand()
                    ->insert('zakaz', ['MarkaAuto' => $marka,   'ModelAuto' => $model, 'YearCon' => $years,   'ValueEngine' => $valueen, 'VIN' => $vin,   'Description' => $description, 'FIO' => $fio, 'Email' => $email, 'Phone' => $phone, 'DateAdd' => $today])
                    ->execute();

                Yii::$app->session->setFlash('success', 'Ваш заказ был успешно отправлен, ожидайте звонка менеджера в ближайшее время');
                return $this->refresh();
            } else {
                $errors = $zakaz_form->errors;
                Yii::$app->session->setFlash('error', 'К сожалению, заказ не был отправлен');
            }
        }
        return $this->render('zakaz', compact('zakaz_form', 'markaArr', 'arrmod'));
    }

    public function actionWishlist($id = '')

    {
        $greeting = $this->getSessionGreeting();
        $customer = $this->getSessionCustomer();
        $wishlist = $this->getWishSession();
        $lang = $this->getSessionLang();
        $current = $this->getSessionCurrent();
        $carts = $this->getCartSession();
        $this->setMetaTags();
        $idCustom = $customer['Id'];
        $idses = 1;
        $cur = $current['Id'];
        $messageWish = '';


        if ($_GET['add'] == 'add') {
            $id = abs((int) $_GET['id']);
            $product = Products::findOne($id);
            $count = $product->MinQunt;
            $carts = $this->getCartSession();

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
            Yii::$app->session->set('cart', $carts);
        }


        if ($_GET['clear'] == 'clear') {

            Yii::$app->session->set('wish_auto', []);
            if ($customer['Id'] != 1) {
                \Yii::$app
                    ->db
                    ->createCommand()
                    ->delete('wishlist', ['IdCustomer' => $customer['Id']])
                    ->execute();
            }
        }
        if (($_GET['del'] == 'delete')) {
            $id = abs((int) $_GET['id']);
            if (isset($wishlist['products'][$id])) {
                unset($wishlist['products'][$id]);
            }
            if ($customer['Id'] != 1) {
                \Yii::$app
                    ->db
                    ->createCommand()
                    ->delete('wishlist', ['IdProduct' => $id, 'IdCustomer' => $customer['Id']])
                    ->execute();
            }

            Yii::$app->session->set('wish_auto', $wishlist);
        }

        $current = Current::findOne($id = $cur);
        $query = Products::find()->select('Id, Name, Description, Img, Img2, Tegs, MetaDescription, MetaTitle, MetaKeyword, IdBrand, Id_lang, Id_category, Price, Id_discont, Availability, Id_current, MinQunt,Status')->orderBy('Name DESC')->all();

        // $wishlists = Wishlist::find()->select('IdCustomer, IdProduct, DateAdd')->where(['IdCustomer' => $idCustom])->all();
        if (count($wishlist) == 0) {
            $messageWish = 'Ваш список бажань порожній';
        }

        $products = [];
        if (count($wishlist) != 0) {
            foreach ($wishlist['products'] as $list) {
                foreach ($query as $items) {
                    if ($list['Id'] == $items->Id) {
                        array_push($products, $items);
                    }
                }
            }
        }
        return $this->render('wishlist', compact('wishlist', 'products', 'current', 'messageWish'));
    }



    public function actionSearch(
        $query = '',
        $page = 1
        //,
        // $oem='', $nodes=''
    ) {

        if ($query === ' ') {
            Yii::$app->session->setFlash('success', 'Введіть дані для пошуку');
            return $this->redirect(Yii::$app->request->referrer);
        }
        $query = trim($query);

        $kurs = Kurs::find()->where(['Id' => 1])->one();


        $page = (int)$page;
        $greeting = $this->getSessionGreeting();
        $customer = $this->getSessionCustomer();
        $wishlist = $this->getWishSession();
        $lang = $this->getSessionLang();
        $current = $this->getSessionCurrent();
        $carts = $this->getCartSession();
        // получаем результаты поиска с постраничной навигацией
        list($products, $pages) = (new Products())->getSearchResult($query, $page);
        //  if (empty($products))
        //  {
        list($zakaz_products, $pagesZ) = (new ZakazProducts())->getSearchResult($query, $page);
        //  } 
        if (($_GET['wish'] == 'add')) {
            $wishlist = $this->getWishSession();
            $id = abs((int) $_GET['id']);
            $product = Products::findOne($id);

            if (isset($wishlist['products'][$product->Id])) { // такой товар уже есть?
                throw new \yii\web\HttpException(404, 'Цей товар вже додано до списку бажань');
            } else { // такого товара еще нет
                $wishlist['products'][$product->Id]['Id'] = $product->Id;
                $wishlist['products'][$product->Id]['Name'] = $product->Name;
                $wishlist['products'][$product->Id]['Price'] = $product->Price;
                $wishlist['products'][$product->Id]['MinQunt'] = $product->MinQunt;
            }

            Yii::$app->session->set('wish_auto', $wishlist);
            $this->redirect(Yii::$app->request->referrer);
        }


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
            if (!empty($carts['products'])) {
                foreach ($carts['products'] as $item) {
                    $amount = $amount + $item['Price'] * $item['Quanty'];
                }
            }
            if (!empty($carts['zakaz'])) {
                foreach ($carts['zakaz'] as $items) {
                    $amount = $amount + $items['Price'] * $items['Quanty'];
                }
            }
            $carts['amount'] = $amount;

            Yii::$app->session->set('cart', $carts);
            $this->redirect(Yii::$app->request->referrer);
        }

        if ($_GET['addZakaz'] == 'add') {

            $id = abs((int) $_GET['id']);
            $product = ZakazProducts::findOne($id);
            $kurs = Kurs::findOne(1);
            if (!empty($product)) {

                $count = 1;
            }


            if (isset($carts['zakaz'][$product->Id])) { // такой товар уже есть?
                $count = $carts['zakaz'][$product->Id]['Quanty'] + $count;

                if ($count > 100) {
                    $count = 100;
                }
                $carts['zakaz'][$product->Id]['Quanty'] = $count;
            } else { // такого товара еще нет
                $carts['zakaz'][$product->Id]['Id'] = $product->Id;
                $carts['zakaz'][$product->Id]['ProductName'] = $product->ProductName;
                $carts['zakaz'][$product->Id]['Price'] = round($product->EntryPrice * (1 + $product->Markup * 0.01) * $kurs->Current_kurs);
                $carts['zakaz'][$product->Id]['Quanty'] = $count;
                //$carts['zakaz'][$product->Id]['TermsDelive']=$product->TermsDelive;
                $carts['zakaz'][$product->Id]['Supplier'] = $product->Supplier;
                $carts['zakaz'][$product->Id]['Brand'] = $product->Brand;
            }
            $amount = 0.0;
            if (!empty($carts['products'])) {
                foreach ($carts['products'] as $item) {
                    $amount = $amount + $item['Price'] * $item['Quanty'];
                }
            }
            if (!empty($carts['zakaz'])) {
                foreach ($carts['zakaz'] as $items) {
                    $amount = $amount + $items['Price'] * $items['Quanty'];
                }
            }
            $carts['amount'] = $amount;
            Yii::$app->session->set('cart', $carts);
            $this->redirect(Yii::$app->request->referrer);
        }

        if ($_GET['delCart'] == 'del') {
            $id = abs((int) $_GET['id']);
            $carts = $this->getCartSession();

            if (isset($carts['products'][$id])) {
                unset($carts['products'][$id]);
            }

            // if (!isset($carts['products'][$id])) {
            //     echo 'ok';
            // }

            if (empty($carts['products'])) {
                Yii::$app->session->set('cart', []);
            }
            $amount = 0.0;
            if (!empty($carts['products'])) {
                foreach ($carts['products'] as $item) {
                    $amount = $amount + $item['Price'] * $item['Quanty'];
                }
            }
            if (!empty($carts['zakaz'])) {
                foreach ($carts['zakaz'] as $items) {
                    $amount = $amount + $items['Price'] * $items['Quanty'];
                }
            }

            $carts['amount'] = $amount;

            Yii::$app->session->set('cart', $carts);
            $this->redirect(Yii::$app->request->referrer);
        }
        if ($_GET['delZakaz'] == 'del') {
            $id = abs((int) $_GET['id']);
            $session = Yii::$app->session;
            $session->open();
            if (!$session->has('cart')) {
                $session->set('cart', []);
                $carts = [];
            }
            $carts = $session->get('cart');

            if (isset($carts['zakaz'][$id])) {
                unset($carts['zakaz'][$id]);
            }


            $amount = 0.0;
            if (!empty($carts['products'])) {
                foreach ($carts['products'] as $item) {
                    $amount = $amount + $item['Price'] * $item['Quanty'];
                }
            }
            if (!empty($carts['zakaz'])) {
                foreach ($carts['zakaz'] as $items) {
                    $amount = $amount + $items['Price'] * $items['Quanty'];
                }
            }
            $carts['amount'] = $amount;

            $session->set('cart', $carts);
            $this->redirect(Yii::$app->request->referrer);
        }
        // устанавливаем мета-теги для страницы
        $this->setMetaTags('Поиск по каталогу');

        return $this->render(
            'search',
            compact(
                'products',
                'pages',
                'pagesZ',
                'wishlist',
                'carts',
                'kurs',
                'current',
                'zakaz_products'
            )
        );
    }

    public function actionPage($slug)
    {
        $lang = $this->getSessionLang();
        // print_r($lang);
        $page = [];
        if ($pageFound = Page::find()->where(['slug' => $slug])->one()) {
            if ($lang['Id'] == 1) {
                $page = [
                    'Name' => $pageFound->Name_ua,
                    'Content' => $pageFound->Content_ua,
                    'Keywords' => $pageFound->Keywords_ua,
                    'Description' => $pageFound->Description_ua,
                    'Content' => $pageFound->Content_ua,
                ];
            } else {
                $page = [
                    'Name' => $pageFound->Name,
                    'Content' => $pageFound->Content,
                    'Keywords' => $pageFound->Keywords,
                    'Description' => $pageFound->Description,
                    'Content' => $pageFound->Content,
                ];
            }
            $this->setMetaTags(
                $page['Name'],
                $page['Keywords'],
                $page['Description']
            );
            return $this->render(
                'page',
                [
                    'page' => $page,
                    'lang' => $lang
                ]
            );
        }
        throw new NotFoundHttpException('Запрошена сторінка не знайдена');
    }
}
