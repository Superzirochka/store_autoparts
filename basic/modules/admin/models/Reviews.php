<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $Id
 * @property int $Id_Costome
 * @property int $IdProduct
 * @property string $Title
 * @property string $Review
 * @property int $Raiting
 * @property string $Date_add
 * @property string $Name
 *
 * @property Customers $costome
 * @property Products $idProduct
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id_Costome', 'IdProduct', 'Title', 'Review', 'Raiting', 'Date_add'], 'required'],
            [['Id_Costome', 'IdProduct', 'Raiting'], 'integer'],
            [['Date_add'], 'safe'],
            [['Title', 'Name'], 'string', 'max' => 250],
            [['Review'], 'string', 'max' => 1000],
            [['Id_Costome'], 'exist', 'skipOnError' => true, 'targetClass' => Customers::class, 'targetAttribute' => ['Id_Costome' => 'Id']],
            [['IdProduct'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['IdProduct' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Id_Costome' => Yii::t('app', 'Покупатель код'),
            'IdProduct' => Yii::t('app', 'Наименование товара'),
            'Title' => Yii::t('app', 'Заглавие'),
            'Review' => Yii::t('app', 'Отзыв'),
            'Raiting' => Yii::t('app', 'Рейтинг'),
            'Date_add' => Yii::t('app', 'Дата добавления'),
            'Name' => Yii::t('app', 'Имя'),
        ];
    }

    /**
     * Gets query for [[Costome]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCostome()
    {
        return $this->hasOne(Customers::class, ['Id' => 'Id_Costome']);
    }

    /**
     * Gets query for [[IdProduct]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdProduct()
    {
        return $this->hasOne(Products::class, ['Id' => 'IdProduct']);
    }
}
