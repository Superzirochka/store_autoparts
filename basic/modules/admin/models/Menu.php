<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "menu".
 *
 * @property int $Id
 * @property string $NameMenu
 * @property string|null $NameMenu_ua
 * @property string $Title
 * @property string|null $Title_ua
 * @property string $Link
 * @property int $Sort
 * @property string $Content
 * @property int $Id_lang
 * @property int|null $Id_parentMenu
 *
 * @property Lang $lang
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NameMenu', 'Title', 'Link', 'Sort', 'Content'], 'required'],
            [['Sort', 'Id_lang', 'Id_parentMenu'], 'integer'],
            [['NameMenu', 'NameMenu_ua'], 'string', 'max' => 150],
            [['Title', 'Title_ua'], 'string', 'max' => 170],
            [['Link'], 'string', 'max' => 500],
            ['Link', 'unique'],
            [['Content'], 'string', 'max' => 1500],
            [['Id_lang'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::class, 'targetAttribute' => ['Id_lang' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'NameMenu' => Yii::t('app', 'Название'),
            'NameMenu_ua' => Yii::t('app', 'Назва Ua'),
            'Title' => Yii::t('app', 'Мета-тег Title'),
            'Title_ua' => Yii::t('app', 'Мета-тег Title Ua'),
            'Link' => Yii::t('app', 'Ссылка'),
            'Sort' => Yii::t('app', 'Сортировка'),
            'Content' => Yii::t('app', 'Содержание'),
            'Id_lang' => Yii::t('app', 'Язык'),
            'Id_parentMenu' => Yii::t('app', 'Родитель'),
        ];
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
     * Возвращает данные о родительской странице
     */
    public function getParent()
    {
        return $this->hasOne(Menu::class, ['Id' => 'Id_parentMenu']);
    }

    /**
     * Возвращает наименование родительской страницы
     */
    public function getParentName()
    {
        $parent = $this->parent;
        return $parent ? $parent->NameMenu : '';
    }

    /**
     * Возвращает массив страниц верхнего уровня для
     * возможности выбора родителя
     */
    public static function getRootPages($exclude = 0)
    {
        $parents = [0 => 'Без родителя'];
        $root = Menu::find()->where(['Id_parentMenu' => 0])->all();
        foreach ($root as $item) {
            if ($exclude == $item['Id']) {
                continue;
            }
            $parents[$item['Id']] = $item['NameMenu'];
        }
        return $parents;
    }

    public static function getTree($parent = 0)
    {
        $children = self::find()
            ->where(['Id_parentMenu' => $parent])
            ->asArray()
            ->all();
        $result = [];
        foreach ($children as $page) {
            if ($parent) {
                $page['NameMenu'] = '— ' . $page['NameMenu'];
            }
            $result[] = $page;
            $result = array_merge(
                $result,
                self::getTree($page['Id'])
            );
        }
        return $result;
    }

    public function beforeDelete()
    {
        $children = self::find()->where(['Id_parentMenu' => $this->Id])->all();
        if (!empty($children)) {
            Yii::$app->session->setFlash(
                'warning',
                'Нельзя удалить пункт меню, который имеет дочерние пункт'
            );
            return false;
        }
        return parent::beforeDelete();
    }
}
