<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "gpuop_customers".
 *
 * @property int $Id
 * @property string $Name
 */
class GpuopCustomers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gpuop_customers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Name'], 'required'],
            [['Name'], 'string', 'max' => 250],
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
        ];
    }

   
}
