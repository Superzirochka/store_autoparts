<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "page".
 *
 * @property int $Id Уникальный идентификатор
 * @property int $parent_id Родительская страница
 * @property string $Name Заголовок страницы
 * @property string $Name_ua
 * @property string $Slug Для создания ссылки
 * @property string|null $Content Содержимое страницы
 * @property string|null $Content_ua
 * @property string|null $Keywords Мета-тег keywords
 * @property string|null $Keywords_ua
 * @property string|null $Description Мета-тег description
 * @property string|null $Description_ua
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'Name', 'Name_ua', 'Slug'], 'required'],
            [['parent_id'], 'integer'],
            [['Content', 'Content_ua'], 'string'],
            [['Name', 'Name_ua', 'Slug'], 'string', 'max' => 100],
            [['Keywords', 'Keywords_ua', 'Description', 'Description_ua'], 'string', 'max' => 255],
            [['Slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Родитель'),
            'Name' => Yii::t('app', 'Заголовок'),
            'Name_ua' => Yii::t('app', 'Заголовок Ua'),
            'Slug' => Yii::t('app', 'Ссылка'),
            'Content' => Yii::t('app', 'Содержание страницы'),
            'Content_ua' => Yii::t('app', 'Зміст сторінки Ua'),
            'Keywords' => Yii::t('app', 'Мета-тег Keywords'),
            'Keywords_ua' => Yii::t('app', 'Мета-тег  Ua'),
            'Description' => Yii::t('app', 'Мета-тег Description'),
            'Description_ua' => Yii::t('app', 'Мета-тег Description Ua'),
        ];
    }

    /**
     * Метод возвращает все страницы в виде дерева
     */
    public static function getTree()
    {
        // пробуем извлечь данные из кеша
        $data = Yii::$app->cache->get('page-menu');
        if ($data === false) {
            // данных нет в кеше, получаем их заново
            $pages = Page::find()
                ->select(['Id', 'Name', 'Slug', 'parent_id', 'Name_ua'])
                ->indexBy('Id')
                ->asArray()
                ->all();
            $data = $pages;
            // сохраняем полученные данные в кеше
            Yii::$app->cache->set('page-menu', $pages, 60);
        }
        return $data;
    }

    /**
     * Принимает на вход линейный массив элеменов, связанных отношениями
     * parent-child, и возвращает массив в виде дерева
     */
    // protected static function makeTree($data = [])
    // {
    //     if (count($data) == 0) {
    //         return [];
    //     }
    //     $tree = [];
    //     foreach ($data as $id => &$node) {
    //         if ($node['parent_id'] == 0) {
    //             $tree[$id] = &$node;
    //         } else {
    //             $data[$node['parent_id']]['childs'][$id] = &$node;
    //         }
    //     }
    //     return $tree;
    // }
}
