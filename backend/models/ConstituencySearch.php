<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Constituency;

/**
 * ConstituencySearch represents the model behind the search form of `backend\models\Constituency`.
 */
class ConstituencySearch extends Constituency
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'district_id'], 'integer'],
            [['name', 'geom','province_id'], 'safe'],
            [['population', 'pop_density', 'area_sq_km'], 'number'],
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
        $query = Constituency::find();

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
            'id' => $this->id,
            'population' => $this->population,
            'pop_density' => $this->pop_density,
            'area_sq_km' => $this->area_sq_km,
            'district_id' => $this->district_id,
        ]);

        $query->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['like', 'geom', $this->geom]);

        return $dataProvider;
    }
}
