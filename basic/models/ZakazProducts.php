<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use Stem\LinguaStemRu;
use yii\db\Query;

/**
 * This is the model class for table "zakaz_zakaz_products".
 *
 * @property int $Id
 * @property string $Supplier поставщик
 * @property string $Brand
 * @property string $ProductName
 * @property string $Description
 * @property float $EntryPrice входная цена
 * @property int $Markup наценка
 * @property float $Price цена
 * @property string $TermsDelive сроки поставки
 * @property string|null $Img
 */
class ZakazProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'zakaz_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Supplier', 'Brand', 'ProductName', 'Description', 'EntryPrice', 'Markup', 'Price', 'TermsDelive', 'Count'], 'required'],
            [['EntryPrice', 'Price'], 'number'],
            [['Markup', 'Count'], 'integer'],
            [['Supplier', 'Brand'], 'string', 'max' => 100],
            [['ProductName'], 'string', 'max' => 250],
            [['Description', 'Img'], 'string', 'max' => 500],
            [['TermsDelive'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Supplier' => Yii::t('app', 'Supplier'),
            'Brand' => Yii::t('app', 'Brand'),
            'ProductName' => Yii::t('app', 'Product Name'),
            'Description' => Yii::t('app', 'Description'),
            'EntryPrice' => Yii::t('app', 'Entry Price'),
            'Markup' => Yii::t('app', 'Markup'),
            'Price' => Yii::t('app', 'Price'),
            'TermsDelive' => Yii::t('app', 'Terms Delive'),
            'Img' => Yii::t('app', 'Img'),
            'Count' => Yii::t('app', 'Count'),

        ];
    }

    // public function getSearchResult(
    //     $search,
    //     $page
    //  ) {
    //     $search = $this->cleanSearchString($search);
    //     //var_dump($search);
    //     if (empty($search)) {
    //         return [null, null];
    //     }
    //     // var_dump($search);
    //     // пробуем извлечь данные из кеша
    //     $key = 'search-' . md5($search) . '-page-' . $page;
    //     //  $data = Yii::$app->cache->get($key);
    //     $data = false;
    //     if ($data === false) {
    //         // данных нет в кеше, получаем их заново
    //         // $query = self::find()->where(['Name' => $search]);
    //         // разбиваем поисковый запрос на отдельные слова
    //         $temp = explode(',', $search);
    //         // var_dump($temp);
    //         $words = [];
    //         $stemmer = new LinguaStemRu();
    //         foreach ($temp as $item) {
    //             if (!empty($item)) {
    //                 // if (iconv_strlen($item) > 3) {
    //                 // получаем корень слова
    //                 // $words[] = $item;
    //                 // } else {
    //                 array_push($words, $item);
    //                 //}
    //             }
    //         }
    //         $analog = Analog::find()->where(['OEM' => $words[0]])->all();

    //         $analogs = [];
    //         foreach ($analog as $an) {
    //             for ($i = 0; $i < (count($words)); $i++) {
    //                 if ($words[$i] !== $an->Analog) {
    //                     array_push($analogs, trim($an->Analog));
    //                 }
    //             }
    //         }

    //         //var_dump(($analogs));
    //         $relevance = "IF (`zakaz_products`.`ProductName` LIKE '%" . $words[0] . "%', 3, 0)";


    //         for ($i = 1; $i < (count($words)); $i++) {
    //             $analog1 = Analog::find()->where(['OEM' => $words[$i]])->all();
    //             foreach ($analog1 as $an) {
    //                 array_push($analogs, $an->Analog);
    //             }
    //             if (($words[$i] !== ' ')) {
    //                 $relevance .= " + IF (`zakaz_products`.`ProductName` LIKE '%" . $words[$i] . "%', 3, 0)";
    //             }
    //         }

    //         //  var_dump($analogs);
    //         if (count($analogs) != 0) {
    //             foreach ($analogs as $an) {

    //                 $relevance .= " + IF (`zakaz_products`.`ProductName` LIKE '%" . $an . "%', 3, 0)";
    //             }
    //         }

    //         $query = (new Query())
    //             ->select([
    //                 'Id' => 'zakaz_products.Id',
    //                 'ProductName' => 'zakaz_products.ProductName',
    //                 'Description' => 'zakaz_products.Description',
    //                 'Supplier' => 'zakaz_products.Supplier',
    //                 'Brand' => 'zakaz_products.Brand',
    //                 'EntryPrice' => 'zakaz_products.EntryPrice',
    //                 'Markup' => 'zakaz_products.Markup',
    //                 'Price' => 'zakaz_products.Price',
    //                 'Img' => 'zakaz_products.Img',
    //                 'TermsDelive' => 'zakaz_products.TermsDelive',
    //                 'Count' => 'zakaz_products.Count',
    //                 'relevance' => $relevance
    //             ])
    //             ->from('zakaz_products')
    //             ->where(['like', 'zakaz_products.ProductName', $words[0]]);
    //         // ->orWhere(['like', 'zakaz_products.Tegs', $analogs[0]])
    //         // ->orWhere(['like', 'zakaz_products.Name', $analogs[0]])

    //         //  var_dump($analogs);
    //         for ($i = 0; $i < (count($analogs)); $i++) {
    //             $query = $query->orWhere(['like', 'zakaz_products.ProductName', $analogs[$i]]);
    //             //print_r($query);              
    //         }
    //         for ($i = 1; $i < (count($words)); $i++) {
    //             if (($words[$i] !== ' ')) {
    //                 $query = $query->orWhere(['like', 'zakaz_products.ProductName', $words[$i]]);
    //             }
    //         }
    //         if (count($analogs) != 0) {
    //             foreach ($analogs as $an) {
    //                 $query = $query->orWhere(['like', 'zakaz_products.ProductName', $an]);
    //             }
    //         }
    //         $query = $query->orderBy(['relevance' => SORT_DESC]);

    //         // посмотрим, какой SQL-запрос был сформирован
    //         //print_r($query->createCommand()->getRawSql());
    //         // постраничная навигация

    //         $pages = new Pagination([
    //             'totalCount' => $query->count(),
    //             'pageSize' =>  Yii::$app->params['pageSize'],
    //             'forcePageParam' => false,
    //             'pageSizeParam' => false,
    //             'pageParam' => 'page-zakaz'
    //         ]);
    //         $zakaz_products = $query
    //             ->offset($pages->offset)
    //             ->limit($pages->limit)
    //             // ->asArray()
    //             ->all();
    //         // сохраняем полученные данные в кеше
    //         $data = [$zakaz_products, $pages];
    //         // Yii::$app->cache->set($key, $data);
    //     }

    //     return $data;
    // }


    public function getSearchResult(
        $search,
        $page
    ) {
        $search = $this->cleanSearchString($search);
        //var_dump($search);
        if (empty($search)) {
            return [null, null];
        }
        // var_dump($search);
        // пробуем извлечь данные из кеша
        $key = 'search-' . md5($search) . '-page-' . $page;
        //  $data = Yii::$app->cache->get($key);
        $data = false;
        if ($data === false) {
            // данных нет в кеше, получаем их заново
            // $query = self::find()->where(['Name' => $search]);
            // разбиваем поисковый запрос на отдельные слова
            $temp = explode(',', $search);
            // var_dump($temp);
            $words = [];

            foreach ($temp as $item) {
                if (!empty($item)) {
                    array_push($words, $item);
                }
            }

            $analog = Analog::find()->where(['OEM' => $words[0]])->all();

            $analogs = [];
            foreach ($analog as $an) {
                for ($i = 0; $i < (count($words)); $i++) {
                    if ($words[$i] !== $an->Analog && !empty($an->Analog)) {
                        array_push($analogs, trim($an->Analog));
                    }
                }
            }

            //var_dump(($analogs));
            //   var_dump(($words));
            $relevance = "IF (`zakaz_products`.`ProductName` LIKE '%" . $words[0] . "%', 3, 0)";


            for ($i = 1; $i < (count($words)); $i++) {
                $analog1 = Analog::find()->where(['OEM' => $words[$i]])->all();
                foreach ($analog1 as $an) {
                    array_push($analogs, $an->Analog);
                    //  var_dump($an->Analog);
                }
                if (($words[$i] !== ' ')) {
                    $relevance .= " + IF (`zakaz_products`.`ProductName` LIKE '%" . $words[$i] . "%', 3, 0)";
                }
            }

            //  var_dump($analogs);
            if (count($analogs) != 0) {
                foreach ($analogs as $an) {

                    $relevance .= " + IF (`zakaz_products`.`ProductName` LIKE '%" . $an . "%', 3, 0)";
                }
            }

            $query = (new Query())
                ->select([
                    'Id' => 'zakaz_products.Id',
                    'ProductName' => 'zakaz_products.ProductName',
                    'Description' => 'zakaz_products.Description',
                    'Supplier' => 'zakaz_products.Supplier',
                    'Brand' => 'zakaz_products.Brand',
                    'EntryPrice' => 'zakaz_products.EntryPrice',
                    'Markup' => 'zakaz_products.Markup',
                    'Price' => 'zakaz_products.Price',
                    'Img' => 'zakaz_products.Img',
                    'TermsDelive' => 'zakaz_products.TermsDelive',
                    'Count' => 'zakaz_products.Count',
                    'relevance' => $relevance
                ])
                ->from('zakaz_products')
                ->where(['like', 'zakaz_products.ProductName', $words[0]]);
            // ->orWhere(['like', 'zakaz_products.Tegs', $analogs[0]])
            // ->orWhere(['like', 'zakaz_products.Name', $analogs[0]])

            //  var_dump($analogs);
            if (!empty($analogs)) {
                for ($i = 0; $i < (count($analogs)); $i++) {
                    $query = $query->orWhere(['like', 'zakaz_products.ProductName', $analogs[$i]]);
                    //print_r($query);              
                }
            }
            for ($i = 1; $i < (count($words)); $i++) {
                if (($words[$i] !== ' ')) {
                    $query = $query->orWhere(['like', 'zakaz_products.ProductName', $words[$i]]);
                }
            }
            if (count($analogs) != 0) {
                foreach ($analogs as $an) {
                    if (!empty($an)) {
                        $query = $query->orWhere(['like', 'zakaz_products.ProductName', $an]);
                    }
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
                'pageSizeParam' => false,
                'pageParam' => 'page-zakaz'
            ]);
            $zakaz_products = $query
                ->offset($pages->offset)
                ->limit($pages->limit)
                // ->asArray()
                ->all();
            // сохраняем полученные данные в кеше
            $data = [$zakaz_products, $pages];
            // Yii::$app->cache->set($key, $data);
        }

        return $data;
    }

    protected function cleanSearchString($search)
    {
        // $search = iconv_substr($search, 0, 64);
        // удаляем все, кроме букв и цифр
        // $search = preg_replace('#[-]#u', ' ', $search); //убирает -
        $search = preg_replace('#[^0-9a-zA-ZА-Яа-яёЁ\-]#u', ' ', $search); // исключаем -' \-'
        // сжимаем двойные пробелы
        $search = preg_replace('#\s+#u', ',', $search);
        $search = trim($search);
        return $search;
    }
}
