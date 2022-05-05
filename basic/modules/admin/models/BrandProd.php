<?

namespace app\modules\admin\models;

use Yii;
use yii\imagine\Image;
use app\modules\admin\models\Products;

/**
 * This is the model class for table "brand_prod".
 *
 * @property int $Id
 * @property string $Brand
 * @property string $Img
 *
 * @property Products[] $products
 */
class BrandProd extends \yii\db\ActiveRecord
{
    public $imageFile;
    public $remove;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brand_prod';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Brand', 'Img'], 'required'],
            [['Brand'], 'string', 'max' => 100],
            [['Img'], 'string', 'max' => 500],
            // атрибут image проверяем с помощью валидатора image
            ['Img', 'image', 'extensions' => 'png, jpg, gif'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif'],
            ['remove', 'safe'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Brand' => Yii::t('app', 'Бренд'),
            'Img' => Yii::t('app', 'Изображение'),
            'remove' => 'Удалить изображение',
            'imageFile'=> 'Загрузить',
        ];
    }

    public function beforeDelete() {
        $products = Products::find()->where(['IdBrand' => $this->Id])->all();
        if (!empty($products)) {
            Yii::$app->session->setFlash(
                'warning',
                'Нельзя удалить бренд, у которого есть товары'
            );
            return false;
        }
        return parent::beforeDelete();
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::class, ['IdBrand' => 'Id']);
    }

    /**
     * Загружает файл изображения бренда
     */

    // public function upload()
    // {
    //     if ($this->validate()) {
    //         $this->imageFile->saveAs(
    //             'brend/{$this->image->baseName}.{$this->image->extension}'
    //         );
    //         // var_dump($this->imageFile);
    //         return true;
    //         // var_dump($this->imageFile);
    //     } else {
    //         return false;
    //     }
    // }
}