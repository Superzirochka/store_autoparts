<?

namespace app\modules\admin\models;

use Yii;
use yii\imagine\Image;
use app\modules\admin\models\Products;

/**
 * This is the model class for table "category".
 *
 * @property int $Id
 * @property int $Id_lang
 * @property string $Name
 * @property string $Description
 * @property string $MetaDescription
 * @property string $MetaTitle
 * @property string $MetaKeyword
 * @property string|null $Img
 * @property int|null $Id_parentCategory
 * @property int|null $id_node
 *
 * @property Lang $lang
 * @property Category $parentCategory
 * @property Category[] $categories
 * @property NodeAuto $node
 * @property Products[] $products
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * Вспомогательный атрибут для загрузки изображения
     */
    public $imageFile;
    public $upload;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id_lang', 'Name', 'Description', 'MetaDescription', 'MetaTitle', 'MetaKeyword'], 'required'],
            [['Id_lang', 'id_node', 'Id_parentCategory'], 'integer'],
            [['Name'], 'string', 'max' => 100],
            // ['Img', 'default', 'value' => NULL],
            [['Description'], 'string', 'max' => 1000],
            [['MetaDescription', 'Img'], 'string', 'max' => 250],
            ['Img', 'image', 'extensions' => 'png, jpg, gif'],
            [['MetaTitle'], 'string', 'max' => 170],
            [['MetaKeyword'], 'string', 'max' => 500],
            [['Id_lang'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::class, 'targetAttribute' => ['Id_lang' => 'Id']],
            [['Id_parentCategory'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['Id_parentCategory' => 'Id']],
            [['id_node'], 'exist', 'skipOnError' => true, 'targetClass' => NodeAuto::class, 'targetAttribute' => ['id_node' => 'Id']],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, gif'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Id_lang' => Yii::t('app', 'Язык'),
            'Name' => Yii::t('app', 'Название'),
            'Description' => Yii::t('app', 'Описание'),
            'MetaDescription' => Yii::t('app', 'Meta Description'),
            'MetaTitle' => Yii::t('app', 'Meta Title'),
            'MetaKeyword' => Yii::t('app', 'Meta Keyword'),
            'Img' => Yii::t('app', 'Картинка'),
            'Id_parentCategory' => Yii::t('app', 'Родительская категория'),
            'id_node' => Yii::t('app', 'Узел'),
            'imageFile' => Yii::t('app', 'Загрузить'),
        ];
    }

    /**
     * Проверка перед удалением категории
     */
    public function beforeDelete()
    {
        $children = self::find()->where(['Id_parentCategory' => $this->Id])->all();
        $products = Products::find()->where(['Id_category' => $this->Id])->all();
        if (!empty($children) || !empty($products)) {
            Yii::$app->session->setFlash(
                'warning',
                'Нельзя удалить категорию, которая имеет товары или дочерние категории'
            );
            return false;
        }
        return parent::beforeDelete();
    }

    /**
     * Gets query for [[Lang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::class, ['Id' => 'Id_lang']);
    }

    /**
     * Gets query for [[ParentCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParentCategory()
    {
        return $this->hasOne(Category::class, ['Id' => 'Id_parentCategory']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['Id_parentCategory' => 'Id']);
    }

    /**
     * Gets query for [[Node]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNode()
    {
        return $this->hasOne(NodeAuto::class, ['Id' => 'id_node']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::class, ['Id_category' => 'Id']);
    }
    public function getProductsCategory()
    {
    }

    public static function getTree()
    {
        $parent =  Yii::$app->cache->get('parent');

        $category = self::find()->all();
        $tree = [];
        $tree[0] = 'Без родителя';
        $level = 0;
        if (!$parent) {
            $parent = [];
            foreach ($category as $cat) {
                if ($cat->Id_parentCategory == null)
                    array_push($parent, $cat);
            }
            // Yii::$app->cache->set('parent', $parent, 3600);
        }
        foreach ($parent as $papy) {
            $tree[$papy['Id']] = $papy['Name'];
            foreach ($category as $item) {

                if ($item['Id_parentCategory'] == $papy['Id'] & $item['Id'] != $papy['Id']) {
                    $level = $level + 1;
                    $tree[$item['Id']] = str_repeat('— ', $level) . $item['Name'];
                    $cat = self::find()
                        ->where(['Id_parentCategory' => $item['Id']])
                        ->asArray()->all();
                    if (count($cat) != 0) {
                        $level = $level + 1;
                        foreach ($cat as $c) {

                            $tree[$c['Id']] = str_repeat('— ', $level) . $c['Name'];
                        }
                    }
                }

                $level = 0;
            }
        }

        return $tree;
    }

    public static function getAllChildIds($id)
    {
        $children = [];
        $ids = self::getChildIds($id);
        foreach ($ids as $item) {
            $children[] = $item;
            $c = self::getAllChildIds($item);
            foreach ($c as $v) {
                $children[] = $v;
            }
        }
        // var_dump($children);
        return $children;
    }

    /**
     * Возвращает массив идентификаторов дочерних категорий (прямых
     * потомков) категории с уникальным идентификатором $id
     */
    protected static function getChildIds($id)
    {
        $children = self::find()->where(['Id_parentCategory' => $id])->asArray()->all();
        $ids = [];
        foreach ($children as $child) {
            $ids[] = $child['Id'];
        }
        return $ids;
    }

    // /**
    //  * Загружает файл изображения категории
    //  */
    // public function uploadImage() {
    //     if ($this->upload) { // только если был выбран файл для загрузки
    //         $name = md5(uniqid(rand(), true)) . '.' . $this->upload->extension;
    //         // сохраняем исходное изображение в директории source
    //         $source = Yii::getAlias('@webroot/img/category/' . $name);
    //         if ($this->upload->saveAs($source)) {
    //             // выполняем resize, чтобы получить маленькое изображение
    //             $thumb = Yii::getAlias('@webroot/img/category/' . $name);
    //             Image::thumbnail($source, 250, 250)->save($thumb, ['quality' => 90]);
    //             return $name;
    //         }
    //     }
    //     return false;
    // }

    // /**
    //  * Удаляет старое изображение при загрузке нового
    //  */
    // public static function removeImage($name) {
    //     if (!empty($name)) {
    //         $source = Yii::getAlias('@webroot/img/category/source/' . $name);
    //         if (is_file($source)) {
    //             unlink($source);
    //         }
    //         $thumb = Yii::getAlias('@webroot/img/category/' . $name);
    //         if (is_file($thumb)) {
    //             unlink($thumb);
    //         }
    //     }
    // }

    // /**
    //  * Удаляет изображение при удалении категории
    //  */
    // public function afterDelete() {
    //     parent::afterDelete();
    //     self::removeImage($this->Img);
    // }
}
