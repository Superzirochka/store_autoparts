<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lang".
 *
 * @property int $Id
 * @property string $language
 * @property string $Abb
 * @property string $Img
 *
 * @property Category[] $categories
 * @property Engine[] $engines
 * @property Menu[] $menus
 * @property NodeAuto[] $nodeAutos
 * @property Products[] $products
 * @property Store[] $stores
 */
class Lang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['language', 'Abb', 'Img'], 'required'],
            [['language'], 'string', 'max' => 100],
            [['Abb'], 'string', 'max' => 5],
            [['Img'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'language' => 'Language',
            'Abb' => 'Abb',
            'Img' => 'Img',
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['Id_lang' => 'Id']);
    }

    /**
     * Gets query for [[Engines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEngines()
    {
        return $this->hasMany(Engine::className(), ['Id_lang' => 'Id']);
    }

    /**
     * Gets query for [[Menus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(Menu::className(), ['Id_lang' => 'Id']);
    }

    /**
     * Gets query for [[NodeAutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNodeAutos()
    {
        return $this->hasMany(NodeAuto::className(), ['Id_lang' => 'Id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['Id_lang' => 'Id']);
    }

    /**
     * Gets query for [[Stores]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStores()
    {
        return $this->hasMany(Store::className(), ['Id_lang' => 'Id']);
    }
}
