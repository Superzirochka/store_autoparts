<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property int $Id
 * @property string $Supplier
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Supplier'], 'required'],
            [['Supplier'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Supplier' => Yii::t('app', 'Поставщики'),
        ];
    }

    public function beforeDelete()
    {
        $products = ZakazProducts::find()->where(['Supplier' => $this->Id])->all();
        if (!empty($products)) {
            Yii::$app->session->setFlash(
                'warning',
                'Нельзя удалить бренд, у которого есть товары'
            );
            return false;
        }
        return parent::beforeDelete();
    }
}
