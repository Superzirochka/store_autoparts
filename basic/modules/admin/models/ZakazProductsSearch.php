<?php

namespace app\modules\admin\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\ZakazProducts;

/**
 * ZakazProductsSearch represents the model behind the search form of `app\modules\admin\models\ZakazProducts`.
 */
class ZakazProductsSearch extends ZakazProducts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Id', 'Markup', 'Count'], 'integer'],
            [['Supplier', 'Brand', 'ProductName', 'Description', 'TermsDelive', 'Img'], 'safe'],
            [['EntryPrice', 'Price'], 'number'],
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
        $query = ZakazProducts::find();

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
            'Supplier' => $this->Supplier,
            'EntryPrice' => $this->EntryPrice,
            // 'Markup' => $this->Markup,
            //'Price' => $this->Price,
            'Count' => $this->Count,
        ]);

        $query->andFilterWhere(['like', 'Supplier', $this->Supplier])
            ->andFilterWhere(['like', 'Brand', $this->Brand])
            ->andFilterWhere(['like', 'ProductName', $this->ProductName])
            ->andFilterWhere(['like', 'Description', $this->Description])
            ->andFilterWhere(['like', 'TermsDelive', $this->TermsDelive])
            //->andFilterWhere(['like', 'Img', $this->Img])
        ;

        return $dataProvider;
    }
}
