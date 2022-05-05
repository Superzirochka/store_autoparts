<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "menu".
 *
 * @property int $Id
 * @property string $NameMenu
 * @property string $Title
 * @property string $Link
 * @property int $Sort
 * @property string $Content
 * @property int $Id_lang
 * @property int|null $Id_parentMenu
 *
 * @property Lang $lang
 * @property Menu $parentMenu
 * @property Menu[] $menus
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
            'Content' => Yii::t('app', 'Содержаниеt'),
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
     * Gets query for [[ParentMenu]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParentMenu()
    {
        return $this->hasOne(Menu::class, ['Id' => 'Id_parentMenu']);
    }

    /**
     * Gets query for [[Menus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::class, ['Id_parentMenu' => 'Id']);
    }
}
