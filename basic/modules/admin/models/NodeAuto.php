<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "node_auto".
 *
 * @property int $Id
 * @property string $Node
 * @property string|null $Node_ua
 * @property int $Id_lang
 * @property int|null $Id_parentNode
 * @property string|null $Img
 *
 * @property Category[] $categories
 * @property Lang $lang
 * @property NodeAuto $parentNode
 * @property NodeAuto[] $nodeAutos
 * @property Oem[] $oems
 */
class NodeAuto extends \yii\db\ActiveRecord
{
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'node_auto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Node', 'Node_ua'], 'required'],
            [['Id_parentNode'], 'integer'],
            [['Node', 'Node_ua'], 'string', 'max' => 250],
            [['Img'], 'string', 'max' => 500],
            [['Id_parentNode'], 'exist', 'skipOnError' => true, 'targetClass' => NodeAuto::class, 'targetAttribute' => ['Id_parentNode' => 'Id']],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg,gif'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => Yii::t('app', 'ID'),
            'Node' => Yii::t('app', 'Название узла'),
            'Node_ua' => Yii::t('app', 'Название узла Ua'),
            'Id_parentNode' => Yii::t('app', 'Родительский узел'),
            'Img' => Yii::t('app', 'Изображение'),
            'imageFile' => Yii::t('app', 'Загрузить'),
        ];
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id_node' => 'Id']);
    }

    /**
     * Gets query for [[Lang]].
     *
     * @return \yii\db\ActiveQuery
     */


    /**
     * Gets query for [[ParentNode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParentNode()
    {
        return $this->hasOne(NodeAuto::class, ['Id' => 'Id_parentNode']);
    }

    /**
     * Gets query for [[NodeAutos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNodeAutos()
    {
        return $this->hasMany(self::class, ['Id_parentNode' => 'Id']);
    }

    /**
     * Gets query for [[Oems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOems()
    {
        return $this->hasMany(Oem::class, ['IdNode' => 'Id']);
    }

    public static function getTree()
    {
        // $parent =  Yii::$app->cache->get('parent');
        $parent = [];
        $category = self::find()->all();
        $tree = [];
        $tree[0] = 'Без родителя';
        $level = 0;
        if (!$parent) {
            $parent = [];
            foreach ($category as $cat) {
                if ($cat->Id_parentNode == null)
                    array_push($parent, $cat);
            }
            // Yii::$app->cache->set('parent', $parent, 3600);
        }
        foreach ($parent as $papy) {
            $tree[$papy['Id']] = $papy['Node'];
            foreach ($category as $item) {

                if ($item['Id_parentNode'] == $papy['Id'] & $item['Id'] != $papy['Id']) {
                    $level = $level + 1;
                    $tree[$item['Id']] = str_repeat('— ', $level) . $item['Node'];
                    $cat = self::find()
                        ->where(['Id_parentNode' => $item['Id']])
                        ->asArray()->all();
                    if (count($cat) != 0) {
                        $level = $level + 1;
                        foreach ($cat as $c) {

                            $tree[$c['Id']] = str_repeat('— ', $level) . $c['Node'];
                        }
                    }
                }

                $level = 0;
            }
        }

        return $tree;
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

    protected static function getChildIds($id)
    {
        $children = self::find()->where(['Id_parentNode' => $id])->asArray()->all();
        $ids = [];
        foreach ($children as $child) {
            $ids[] = $child['Id'];
        }
        return $ids;
    }
}
