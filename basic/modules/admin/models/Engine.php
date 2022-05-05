<?php

namespace app\modules\admin\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "engine".
 *
 * @property int $Id
 * @property string $Name
 * @property int $Id_lang
 *
 * @property Lang $lang
 * @property Modification[] $modifications
 */
class Engine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'engine';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name', 'Id_lang'], 'required'],
            [['Id_lang'], 'integer'],
            [['Name'], 'string', 'max' => 20],
            [['Id_lang'], 'exist', 'skipOnError' => true, 'targetClass' => Lang::className(), 'targetAttribute' => ['Id_lang' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Name' => Yii::t('app', 'Name'),
            'Id_lang' => Yii::t('app', 'Id Lang'),
        ];
    }

    /**
     * Gets query for [[Lang]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['Id' => 'Id_lang']);
    }

    /**
     * Gets query for [[Modifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModifications()
    {
        return $this->hasMany(Modification::className(), ['IdEngine' => 'Id']);
    }

    public static function getParentsList()
    {
        // Выбираем только те категории, у которых есть дочерние категории
        $parents = self::find()
            ->select(['Id', 'Name'])
            //->join('JOIN', 'category c', 'category.parent_id = c.id')
            ->distinct(true)
            ->all();

        return ArrayHelper::map($parents, 'Id', 'Name');
    }
}
