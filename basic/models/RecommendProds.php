<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "recommend_prods".
 *
 * @property int $Id
 * @property int $Id_products
 * @property int $Id_recomend
 *
 * @property Products $products
 * @property Products $recomend
 */
class RecommendProds extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recommend_prods';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id_products', 'Id_recomend'], 'required'],
            [['Id_products', 'Id_recomend'], 'integer'],
            [['Id_products'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['Id_products' => 'Id']],
            [['Id_recomend'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['Id_recomend' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Id_products' => 'Id Products',
            'Id_recomend' => 'Id Recomend',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasOne(Products::className(), ['Id' => 'Id_products']);
    }

    /**
     * Gets query for [[Recomend]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecomend()
    {
        return $this->hasOne(Products::className(), ['Id' => 'Id_recomend']);
    }
}
