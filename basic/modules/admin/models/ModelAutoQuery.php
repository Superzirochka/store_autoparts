<?php

namespace app\modules\admin\models;

/**
 * This is the ActiveQuery class for [[ModelAuto]].
 *
 * @see ModelAuto
 */
class ModelAutoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ModelAuto[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ModelAuto|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
