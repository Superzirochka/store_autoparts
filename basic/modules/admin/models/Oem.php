<?php

namespace app\modules\admin\models;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "oem".
 *
 * @property int $Id
 * @property string $OEM
 * @property int $IdNode
 * @property int $Id_auto
 * @property string $Img
 *
 * @property NodeAuto $idNode
 * @property Modification $auto
 */
class Oem extends \yii\db\ActiveRecord
{
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['OEM', 'IdNode', 'Id_auto'], 'required'],
            [['IdNode', 'Id_auto'], 'integer'],
            [['OEM', 'Img'], 'string', 'max' => 500],
            [['Description_ua', 'Description'], 'string', 'max' => 5000],
            //[['OEM'], 'unique'],
            [['IdNode'], 'exist', 'skipOnError' => true, 'targetClass' => NodeAuto::class, 'targetAttribute' => ['IdNode' => 'Id']],
            [['Id_auto'], 'exist', 'skipOnError' => true, 'targetClass' => Modification::class, 'targetAttribute' => ['Id_auto' => 'Id']],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg,gif'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'OEM' => Yii::t('app', 'OEM'),
            'IdNode' => Yii::t('app', 'Узел авто'),
            'Id_auto' => Yii::t('app', 'Модель авто'),
            'Img' => Yii::t('app', 'Изображение'),
            'imageFile' => Yii::t('app', 'Загрузить'),
            'Description' => Yii::t('app', 'Описание'),
            'Description_ua' => Yii::t('app', 'Опис'),
        ];
    }

    /**
     * Gets query for [[IdNode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdNode()
    {
        return $this->hasOne(NodeAuto::class, ['Id' => 'IdNode']);
    }

    /**
     * Gets query for [[Auto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuto()
    {
        return $this->hasOne(Modification::class, ['Id' => 'Id_auto']);
    }

    public function findModel($id)
    {
        $model = Oem::find()->where(['Id_auto' => $id])->all();
        if (
            $model !== null
        ) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
