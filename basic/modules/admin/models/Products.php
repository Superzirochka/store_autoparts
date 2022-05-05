<?

namespace app\modules\admin\models;

use Yii;
use \yii\imagine\Image;
use yii\db\Query;
use yii\data\Pagination;

/**
 * This is the model class for table "products".
 *
 * @property int $Id
 * @property string $Name
 * @property string|null $Description
 * @property string $Img
 * @property string|null $Img2
 * @property string $MetaDescription
 * @property string $MetaTitle
 * @property string $MetaKeyword
 * @property int $IdBrand
 * @property int $Id_lang
 * @property int $Id_category
 * @property float $Price
 * @property int|null $Id_discont
 * @property int $Availability
 * @property int $Id_current
 * @property int $MinQunt
 * @property string $Units
 * @property string $DateAdd
 *
 * @property Carts[] $carts
 * @property ProductImg[] $productImgs
 * @property Lang $lang
 * @property BrandProd $idBrand
 * @property Discont $discont
 * @property Current $current
 * @property Category $category
 * @property RecommendProds[] $recommendProds
 * @property RecommendProds[] $recommendProds0
 * @property Reviews[] $reviews
 * @property Wishlist[] $wishlists
 */
class Products extends \yii\db\ActiveRecord
{

    /**
     * Вспомогательный атрибут для загрузки изображения товара
     */
    public $imageFile1;
    public $imageFile2;
    const STATUS_ACTIVE = 10;
    const STATUS_DELETE = 0;

    /**
     * Вспомогательный атрибут для удаления изображения товара
     */
    public $remove;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name', 'Img', 'MetaDescription', 'MetaTitle', 'MetaKeyword', 'IdBrand', 'Id_lang', 'Id_category', 'MinQunt', 'Units'], 'required'],
            [['Description', 'Description_ua', 'Tegs'], 'string'],
            [['IdBrand', 'Id_lang', 'Id_category', 'Id_discont', 'Availability', 'Id_current', 'MinQunt', 'Markup'], 'integer'],
            [['Price', 'Conventional_units'], 'integer', 'integerOnly' => false],
            [['DateAdd'], 'safe'],
            [['Name'], 'string', 'max' => 100],
            ['Img', 'default', 'value' => NULL],
            ['Markup', 'default', 'value' => 50],
            ['Img2', 'image', 'extensions' => 'png, jpg, gif'],
            ['remove', 'safe'],
            // [['Img'], 'string', 'max' => 150],
            [['Img2', 'MetaKeyword', 'MetaKeyword_ua'], 'string', 'max' => 500],
            [['MetaDescription', 'MetaDescription_ua'], 'string', 'max' => 250],
            [['MetaTitle', 'MetaTitle_ua'], 'string', 'max' => 170],
            [['Units'], 'string', 'max' => 20],
            [['Id_lang'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::class, 'targetAttribute' => ['Id_lang' => 'Id']],
            [['IdBrand'], 'exist', 'skipOnError' => true, 'targetClass' => BrandProd::class, 'targetAttribute' => ['IdBrand' => 'Id']],
            [['Id_discont'], 'exist', 'skipOnError' => true, 'targetClass' => Discont::class, 'targetAttribute' => ['Id_discont' => 'Id']],
            [['Id_current'], 'exist', 'skipOnError' => true, 'targetClass' => Current::class, 'targetAttribute' => ['Id_current' => 'Id']],
            [['Id_category'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['Id_category' => 'Id']],
            [['imageFile1', 'imageFile2'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, gif'],
            ['Status', 'default', 'value' => self::STATUS_ACTIVE],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Name' => Yii::t('app', 'Наименование'),
            'Description' => Yii::t('app', 'Описание'),
            'Description_ua' => Yii::t('app', 'Опис'),
            'Img' => Yii::t('app', 'Картинка'),
            'Img2' => Yii::t('app', 'Картинка доп'),
            'Tegs' => Yii::t('app', 'Критерии поиска'),
            'MetaDescription' => Yii::t('app', 'Meta Description'),
            'MetaDescription_ua' => Yii::t('app', 'Meta Description UA'),
            'MetaTitle' => Yii::t('app', 'MetaTitle'),
            'MetaTitle_ua' => Yii::t('app', 'MetaTitle UA'),
            'MetaKeyword' => Yii::t('app', 'Meta Keyword'),
            'MetaKeyword_ua' => Yii::t('app', 'Meta Keyword UA'),
            'IdBrand' => Yii::t('app', 'Бренд'),
            'Id_lang' => Yii::t('app', 'Язык'),
            'Id_category' => Yii::t('app', 'Категория'),
            'Markup' => Yii::t('app', 'Наценка'),
            'Conventional_units' => Yii::t('app', 'у.е'),
            'Price' => Yii::t('app', 'Цена'),
            'Id_discont' => Yii::t('app', 'Скидка'),
            'Availability' => Yii::t('app', 'Доступное количество'),
            'Id_current' => Yii::t('app', 'Валюта'),
            'MinQunt' => Yii::t('app', 'Минимальный заказ'),
            'Units' => Yii::t('app', 'Единицы'),
            'DateAdd' => Yii::t('app', 'Дата добавления/измениения'),
            'remove' => 'Удалить изображение',
            'imageFile1' => 'Загрузить',
            'imageFile2' => 'Загрузить',
            'Status' => Yii::t('app', 'Статус'),
        ];
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Carts::class, ['IdProduct' => 'Id']);
    }

    /**
     * Gets query for [[ProductImgs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductImgs()
    {
        return $this->hasMany(ProductImg::class, ['IdProduct' => 'Id']);
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
     * Gets query for [[IdBrand]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdBrand()
    {
        return $this->hasOne(BrandProd::class, ['Id' => 'IdBrand']);
    }

    /**
     * Gets query for [[Discont]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDiscont()
    {
        return $this->hasOne(Discont::class, ['Id' => 'Id_discont']);
    }

    /**
     * Gets query for [[Current]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrent()
    {
        return $this->hasOne(Current::class, ['Id' => 'Id_current']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['Id' => 'Id_category']);
    }

    /**
     * Gets query for [[RecommendProds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecommendProds()
    {
        return $this->hasMany(RecommendProds::class, ['Id_products' => 'Id']);
    }

    /**
     * Gets query for [[RecommendProds0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecommendProds0()
    {
        return $this->hasMany(RecommendProds::class, ['Id_recomend' => 'Id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['IdProduct' => 'Id']);
    }

    /**
     * Gets query for [[Wishlists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWishlists()
    {
        return $this->hasMany(Wishlist::class, ['IdProduct' => 'Id']);
    }




    public static function getTree()
    {
        $parent =  Yii::$app->cache->get('parent');

        $category = Category::find()->all();
        $tree = [];
        $level = 0;
        if (!$parent) {
            $parent = [];
            foreach ($category as $cat) {
                if ($cat->Id_parentCategory == null)
                    array_push($parent, $cat);
            }
            Yii::$app->cache->set('parent', $parent, 3600);
        }
        foreach ($parent as $papy) {
            $tree[$papy['Id']] = $papy['Name'];
            foreach ($category as $item) {

                if ($item['Id_parentCategory'] == $papy['Id'] & $item['Id'] != $papy['Id']) {
                    $level = $level + 1;
                    $tree[$item['Id']] = str_repeat('— ', $level) . $item['Name'];
                    $cat = Category::find()
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


    /**
     * Удаляет старое изображение при загрузке нового
     */

    /**
     * Удаляет изображение при удалении товара
     */
    // public function afterDelete()
    // {
    //     parent::afterDelete();
    //     self::removeImage($this->Img);
    // }

    protected function cleanSearchString($search)
    {
        $search = iconv_substr($search, 0, 64);
        // удаляем все, кроме букв и цифр
        // $search = preg_replace('#[-]#u', ' ', $search); //убирает -
        $search = preg_replace('#[^0-9a-zA-ZА-Яа-яёЁ\-]#u', ' ', $search); // исключаем -' \-'
        // сжимаем двойные пробелы
        //   $search = preg_replace('#\s+#u', ' ', $search);
        $search = trim($search);
        return $search;
    }

    public function getSearchAnalogResult($search, $page = 1)
    {
        if (empty($search)) {
            return [null, null];
        }

        // пробуем извлечь данные из кеша
        $key = 'search-' . md5($search) . '-page-' . $page;
        // $data = Yii::$app->cache->get($key);
        $data = false;
        if ($data === false) {
            // данных нет в кеше, получаем их заново
            // $query = self::find()->where(['Name' => $search]);
            // разбиваем поисковый запрос на отдельные слова
            $temp = explode(',', $search);
            // var_dump($temp);
            $words = [];
            //  $stemmer = new LinguaStemRu();
            foreach ($temp as $item) {
                if (iconv_strlen($item) > 3) {
                    // получаем корень слова
                    $words[] = $item;
                    //   $words[] = $stemmer->stem_word($item);
                } else {
                    $words[] = $item;
                }
            }
            $analog = Analog::find()->where(['OEM' => $words[0]])->all();
            $analogs = [];
            foreach ($analog as $an) {
                array_push($analogs, $an->Analog);
            }

            //var_dump(($words));
            $relevance = "IF (`products`.`Name` LIKE '%" . $words[0] . "%', 3, 0)";
            $relevance .= " + IF (`products`.`Tegs` LIKE '%" . $words[0] . "%', 3, 0)";
            // $relevance .= " + IF (`products`.`MetaKeyword` LIKE '%" . $words[0] . "%', 2, 0)";
            //  $relevance .= " + IF (`products`.`Description` LIKE '%" . $words[0] . "%', 2, 0)";
            //  $relevance .= " + IF (`products`.`MetaTitle` LIKE '%" . $words[0] . "%', 2, 0)";
            //   $relevance .= " + IF (`products`.`MetaDescription` LIKE '%" . $words[0] . "%', 2, 0)";
            //   $relevance .= " + IF (`category`.`Name` LIKE '%" . $words[0] . "%', 1, 0)";
            //   $relevance .= " + IF (`brand_prod`.`Brand` LIKE '%" . $words[0] . "%', 1, 0)";
            //var_dump($words[count($words)]);
            for ($i = 1; $i < (count($words)); $i++) {
                $analog1 = Analog::find()->where(['OEM' => $words[$i]])->all();
                foreach ($analog1 as $an) {
                    array_push($analogs, $an->Analog);
                }
                if (($words[$i] !== ' ')) {
                    $relevance .= " + IF (`products`.`Name` LIKE '%" . $words[$i] . "%', 3, 0)";
                    $relevance .= " + IF (`products`.`Tegs` LIKE '%" . $words[$i] . "%', 2, 0)";
                }
                // $relevance .= " + IF (`products`.`MetaKeyword` LIKE '%" . $words[$i] . "%', 2, 0)";
                //     $relevance .= " + IF (`products`.`Description` LIKE '%" . $words[$i] . "%', 2, 0)";
                //    $relevance .= " + IF (`products`.`MetaTitle` LIKE '%" . $words[$i] . "%', 2, 0)";
                //    $relevance .= " + IF (`products`.`MetaDescription` LIKE '%" . $words[$i] . "%', 2, 0)";
                //   $relevance .= " + IF (`category`.`Name` LIKE '%" . $words[$i] . "%', 1, 0)";
                //   $relevance .= " + IF (`brand_prod`.`Brand` LIKE '%" . $words[$i] . "%', 1, 0)";
            }

            //  var_dump($analogs);
            if (count($analogs) != 0) {
                foreach ($analogs as $an) {
                    $relevance .= " + IF (`products`.`Tegs` LIKE '%" . $an . "%', 3, 0)";
                    $relevance .= " + IF (`products`.`Name` LIKE '%" . $an . "%', 3, 0)";
                }
            }

            $query = (new Query())
                ->select([
                    'Id' => 'products.Id',
                    'Name' => 'products.Name',
                    'Description' => 'products.Description',
                    'Description_ua' => 'products.Description_ua',
                    'MetaDescription' => 'products.MetaDescription',
                    'MetaDescription_ua' => 'products.MetaDescription_ua',
                    'MetaTitle' => 'products.MetaTitle',
                    'MetaTitle_ua' => 'products.MetaTitle_ua',
                    'MetaKeyword' => 'products.MetaKeyword',
                    'MetaKeyword_ua' => 'products.MetaKeyword_ua',
                    'Price' => 'products.Price',
                    'Img' => 'products.Img',
                    'Tegs' => 'products.Tegs',
                    'Status' => 'products.Status',
                    'relevance' => $relevance
                ])
                ->from('products')
                //  ->join('INNER JOIN', 'category', 'category.Id = products.Id_category')
                //  ->join('INNER JOIN', 'brand_prod', 'brand_prod.Id = products.IdBrand')
                ->where(['like', 'products.Name', $words[0]])
                // ->orWhere(['like', 'products.Tegs', $analogs[0]])
                // ->orWhere(['like', 'products.Name', $analogs[0]])
                ->orWhere(['like', 'products.Tegs', $words[0]])
                //  ->orWhere(['like', 'products.MetaKeyword', $words[0]])
                // ->orWhere(['like', 'products.Description', $words[0]])
                // ->orWhere(['like', 'products.MetaTitle', $words[0]])
                //  ->orWhere(['like', 'products.MetaDescription', $words[0]])
                //  ->orWhere(['like', 'category.Name', $words[0]])
                //  ->orWhere(['like', 'brand_prod.Brand', $words[0]])
            ;
            //  var_dump($analogs);
            for ($i = 0; $i < (count($analogs)); $i++) {
                $query = $query->orWhere(['like', 'products.Name', $analogs[$i]]);
                //print_r($query);
                $query = $query->orWhere(['like', 'products.Tegs', $analogs[$i]]);
            }
            for ($i = 1; $i < (count($words)); $i++) {
                if (($words[$i] !== ' ')) {
                    $query = $query->orWhere(['like', 'products.Name', $words[$i]]);
                    $query = $query->orWhere(['like', 'products.Tegs', $words[$i]]);
                }
                // $query = $query->orWhere(['like', 'products.MetaKeyword', $words[$i]]);
                //  $query = $query->orWhere(['like', 'products.Description', $words[$i]]);
                //  $query = $query->orWhere(['like', 'products.MetaTitle', $words[$i]]);
                //  $query = $query->orWhere(['like', 'products.MetaDescription', $words[$i]]);
                //   $query = $query->orWhere(['like', 'category.Name', $words[$i]]);
                //  $query = $query->orWhere(['like', 'brand_prod.Brand', $words[$i]]);
            }
            if (count($analogs) != 0) {
                foreach ($analogs as $an) {
                    $query = $query->orWhere(['like', 'products.Name', $an]);
                    $query = $query->orWhere(['like', 'products.Tegs', $an]);
                }
            }
            $query = $query->orderBy(['relevance' => SORT_DESC]);

            // посмотрим, какой SQL-запрос был сформирован
            //print_r($query->createCommand()->getRawSql());
            // постраничная навигация
            $pages = new Pagination([
                'totalCount' => $query->count(),
                'pageSize' =>  Yii::$app->params['pageSize'],
                'forcePageParam' => false,
                'pageSizeParam' => false
            ]);
            $products = $query
                ->offset($pages->offset)
                ->limit($pages->limit)
                // ->asArray()
                ->all();
            // сохраняем полученные данные в кеше
            $data = [$products, $pages];
            // Yii::$app->cache->set($key, $data);
        }

        //print_r($query->createCommand()->getRawSql());
        //var_dump($data);
        return $query;
        //$data;
    }
}
