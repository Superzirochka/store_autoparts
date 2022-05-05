<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
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
class OemSearch extends Oem
{
    /**
     */
    public function rules()
    {
        return [
            [['Id'], 'integer'],
            [['OEM', 'IdNode'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = // $this->findModel($params['idmodif']);
            Oem::find()->where(['Id_auto' => $params['idmodif']]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'Id' => $this->Id,
            'IdNode' => $this->IdNode
        ]);
        if (!empty($this->IdNode)) {
            $node = NodeAuto::find()->where(['Id' => $this->IdNode])->one();
            if ($node->Id_parentNode == NULL) {
                $children = NodeAuto::getAllChildIds($node->Id);
                //find()->where(['Id_parentNode' => $node->Id])->all();
                // var_dump($children);
                if (!empty($children)) {
                    foreach ($children as $child) {
                        $query->andFilterWhere(['like', 'OEM', $this->OEM])
                            //->andFilterWhere(['like', 'IdNode', $this->IdNode])
                            ->andFilterWhere(['IdNode' => $child]);
                    }
                }
                $query->andFilterWhere(['like', 'OEM', $this->OEM])
                    //->andFilterWhere(['like', 'IdNode', $this->IdNode])
                    ->andFilterWhere(['IdNode' => $node->Id]);
            } else {
                $query->andFilterWhere(['like', 'OEM', $this->OEM])
                    //->andFilterWhere(['like', 'IdNode', $this->IdNode])
                    ->andFilterWhere(['like', 'IdNode', $this->IdNode]);
            }
        } else {
            $query->andFilterWhere(['like', 'OEM', $this->OEM])
                //->andFilterWhere(['like', 'IdNode', $this->IdNode])
                ->andFilterWhere(['like', 'IdNode', $this->IdNode]);
        }
        return $dataProvider;
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
