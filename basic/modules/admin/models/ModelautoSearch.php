<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\ModelAuto;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ManufacturerautoSearch represents the model behind the search form of `app\modules\admin\models\ManufacturerAuto`.
 */
class ModelautoSearch extends ModelAuto
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id'], 'integer'],
            [['ModelName', 'FullName', 'constructioninterval'], 'safe'],
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
        $query = ModelAuto::find()->where(['IdManufacturer' => $id]);

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

        $query->andFilterWhere(['like', 'ModelName', $this->ModelName])
            ->andFilterWhere(['like', 'FullName', $this->FullName])
            ->andFilterWhere(['like', 'constructioninterval', $this->constructioninterval]);

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
