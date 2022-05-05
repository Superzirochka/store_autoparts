<?php

namespace app\modules\admin\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "value_engine".
 *
 * @property int $Id
 * @property string $Value
 *
 * @property Modification[] $modifications
 */
class ValueEngine extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'value_engine';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Value'], 'required'],
            [['Value'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Value' => Yii::t('app', 'Объем'),
        ];
    }

    /**
     * Gets query for [[Modifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModifications()
    {
        return $this->hasMany(Modification::class, ['IdValueEngine' => 'Id']);
    }

    public static function value($status): string
    {
        return ArrayHelper::getValue(self::find(), $status);
    }

    public static function getParentsList()
    {
        // Выбираем только те категории, у которых есть дочерние категории
        $parents = self::find()
            ->select(['Id', 'Value'])
            ->orderBy('Value ASC')
            //->join('JOIN', 'category c', 'category.parent_id = c.id')
            ->distinct(true)
            ->all();

        return ArrayHelper::map($parents, 'Id', 'Value');
    }
}
