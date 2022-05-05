<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\Modification;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ManufacturerautoSearch represents the model behind the search form of `app\modules\admin\models\ManufacturerAuto`.
 */
class ModificationSearch extends Modification
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id'], 'integer'],
            [['IdModelAuto', 'IdEngine', 'IdValueEngine'], 'safe'],
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
    public function search($params, $id)
    {
        // if (($model = ManufacturerAuto::findOne($id)) !== null) {
        //     return $model;
        // }
        $query = Modification::find()->where(['IdModelAuto' => $id]);

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
        ]);

        $query->andFilterWhere(['like', 'IdModelAuto', $this->IdModelAuto])
            ->andFilterWhere(['like', 'IdEngine', $this->IdEngine])
            ->andFilterWhere(['like', 'IdValueEngine', $this->IdValueEngine]);

        return $dataProvider;
    }

    // protected function findModel($id)
    // {
    //     if (($model = ModelAuto::find()->where(['IdManufacturer' => $id])) !== null) {
    //         return $model;
    //     }

    //     throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    // }
}
