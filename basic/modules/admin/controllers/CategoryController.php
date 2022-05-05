<?

namespace app\modules\admin\controllers;

use Yii;
use app\modules\admin\models\Category;
use yii\data\ActiveDataProvider;
use app\modules\admin\controllers\AdminController;
use app\modules\admin\models\Products;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends AdminController
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'categories' => Category::getTree()
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();


        if ($model->load(Yii::$app->request->post())
            // && $model->save()
        ) {
            if ($model->Id_parentCategory == 0) {
                $model->Id_parentCategory = null;
            }
            $imageName = time();
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            //  $text=NULL;
            echo $model->imageFile;
            if (!empty($model->imageFile)) {
                $model->imageFile->saveAs('img/category/' . $model->Name . '-' . $imageName . '.' . $model->imageFile->extension);
                $model->Img = 'category/' . $model->Name . '-' . $imageName . '.' . $model->imageFile->extension;
                // $text=$model->Img;

            }

            // if(empty($model->imageFile)) {
            //     $model->Img = 'products/defult_prodact.jpg';
            // }

            \Yii::$app
                ->db
                ->createCommand()
                ->insert('category', [
                    'Name' => $model->Name, 'Description' => $model->Description, 'Img' => $model->Img,
                    'Id_lang' => 1, 'MetaDescription' => $model->MetaDescription, 'MetaTitle' => $model->MetaTitle, 'MetaKeyword' => $model->MetaKeyword, 'Id_parentCategory' => $model->Id_parentCategory, 'id_node' => $model->id_node
                ])
                ->execute();

            // $model->save();
            $category = Category::find()->orderBy(['id' => SORT_DESC])->one();
            return $this->redirect(['view', 'id' => $category->Id]);

            // return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old = $model->Img;
        // if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        //     $model->upload = UploadedFile::getInstance($model, 'Img');
        //     if ($new = $model->uploadImage()) { // если изображение было загружено
        //         // удаляем старое изображение
        //         if (!empty($old)) {
        //             $model::removeImage($old);
        //         }
        //         // сохраняем в БД новое имя
        //         $model->Img = $new;
        //     } else { // оставляем старое изображение
        //         $model->Img = $old;
        //     }
        // }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->Id_parentCategory == 0) {
                $model->Id_parentCategory = null;
            }

            $imageName = time();
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if (!empty($model->imageFile)) {
                $model->imageFile->saveAs('img/category/' . $model->Name . '-' . $imageName . '.' . $model->imageFile->extension);
                $model->Img = 'category/' . $model->Name . '-' . $imageName . '.' . $model->imageFile->extension;
            }

            \Yii::$app
                ->db
                ->createCommand()
                ->update('category', [
                    'Name' => $model->Name, 'Description' => $model->Description, 'Img' => $model->Img,
                    'Id_lang' => 1, 'MetaDescription' => $model->MetaDescription, 'MetaTitle' => $model->MetaTitle, 'MetaKeyword' => $model->MetaKeyword, 'Id_parentCategory' => $model->Id_parentCategory, 'id_node' => $model->id_node
                ], 'Id=' . $model->Id)
                ->execute();
            $category = Category::find()->orderBy(['id' => SORT_DESC])->one();

            return $this->redirect(['view', 'id' => $category->Id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'Запрашиваемая страница не существует.'));
    }

    public function actionProducts($id)
    {
        // получаем массив идентификаторов всех потомков категории,
        // чтобы запросом выбрать товары и в дочерних категориях
        $ids = Category::getAllChildIds($id);
        $ids[] = $id;
        $products = new ActiveDataProvider([
            'query' => Products::find()->where(['in', 'Id_category', $ids])
        ]);
        return $this->render(
            'products',
            [
                'category' => $this->findModel($id),
                'products' => $products,
            ]
        );
    }
}
