<?php

namespace app\modules\admin\models;

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
 * @property string $Content_ua
 * @property string|null $Keywords Мета-тег keywords
 * @property string $Keywords_ua
 * @property string|null $Description Мета-тег description
 * @property string $Description_ua
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
            //    ['Slug', 'match', 'pattern' => '/^[a-z][-_a-z0-9]*$/i'],
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
            'Keywords_ua' => Yii::t('app', 'Мета-тег Keywords Ua'),
            'Description' => Yii::t('app', 'Мета-тег Description'),
            'Description_ua' => Yii::t('app', 'Мета-тег Description Ua'),
        ];
    }

    public function beforeDelete()
    {
        $children = self::find()->where(['parent_id' => $this->Id])->all();
        if (!empty($children)) {
            Yii::$app->session->setFlash(
                'warning',
                'Нельзя удалить страницу, которая имеет дочерние стрницы'
            );
            return false;
        }
        return parent::beforeDelete();
    }

    /**
     * Возвращает данные о родительской странице
     */
    public function getParent()
    {
        return $this->hasOne(Page::class, ['Id' => 'parent_id']);
    }

    /**
     * Возвращает наименование родительской страницы
     */
    public function getParentName()
    {
        $parent = $this->parent;
        return $parent ? $parent->Name : '';
    }

    /**
     * Возвращает массив страниц верхнего уровня для
     * возможности выбора родителя
     */
    public static function getRootPages($exclude = 0)
    {
        $parents = [0 => 'Без родителя'];
        $root = Page::find()->where(['parent_id' => 0])->all();
        foreach ($root as $item) {
            if ($exclude == $item['Id']) {
                continue;
            }
            $parents[$item['Id']] = $item['Name'];
        }
        return $parents;
    }

    public static function getTree($parent = 0)
    {
        $children = self::find()
            ->where(['parent_id' => $parent])
            ->asArray()
            ->all();
        $result = [];
        foreach ($children as $page) {
            if ($parent) {
                $page['Name'] = '— ' . $page['Name'];
            }
            $result[] = $page;
            $result = array_merge(
                $result,
                self::getTree($page['Id'])
            );
        }
        return $result;
    }
}
