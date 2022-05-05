<?php

namespace app\models;

use Yii;

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
            [['Id_lang', 'Id_parentCategory', 'id_node'], 'integer'],
            [['Name'], 'string', 'max' => 100],
            [['Description'], 'string', 'max' => 1000],
            [['MetaDescription', 'Img'], 'string', 'max' => 250],
            [['MetaTitle'], 'string', 'max' => 170],
            [['MetaKeyword'], 'string', 'max' => 500],
            [['Id_lang'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::className(), 'targetAttribute' => ['Id_lang' => 'Id']],
            [['Id_parentCategory'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['Id_parentCategory' => 'Id']],
            // [['id_node'], 'exist', 'skipOnError' => true, 'targetClass' => NodeAuto::className(), 'targetAttribute' => ['id_node' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Id_lang' => 'Id Lang',
            'Name' => 'Name',
            'Description' => 'Description',
            'MetaDescription' => 'Meta Description',
            'MetaTitle' => 'Meta Title',
            'MetaKeyword' => 'Meta Keyword',
            'Img' => 'Img',
            'Id_parentCategory' => 'Id Parent Category',
            'id_node' => 'Id Node',
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
    // public function getNode()
    // {
    //     return $this->hasOne(NodeAuto::className(), ['Id' => 'id_node']);
    // }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        //     return $this->hasMany(Products::className(), ['Id_category' => 'Id']);
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
}
