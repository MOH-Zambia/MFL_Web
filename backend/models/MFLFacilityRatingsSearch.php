<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MFLFacilityRatings;

/**
 * MFLFacilityRatingsSearch represents the model behind the search form of `backend\models\MFLFacilityRatings`.
 */
class MFLFacilityRatingsSearch extends MFLFacilityRatings
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'rate_type_id', 'date_created', 'facility_id','rate_value'], 'integer'],
            [['rating', 'email', 'comment'], 'safe'],
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
        $query = MFLFacilityRatings::find();

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
            'rate_type_id' => $this->rate_type_id,
            'date_created' => $this->date_created,
            'facility_id' => $this->facility_id,
            'rate_value' => $this->rate_value,
        ]);

        $query->andFilterWhere(['ilike', 'rating', $this->rating])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'comment', $this->comment]);

        return $dataProvider;
    }
}
