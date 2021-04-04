<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Indicators;

/**
 * IndicatorsSearch represents the model behind the search form of `backend\models\Indicators`.
 */
class IndicatorsSearch extends Indicators
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'indicator_group_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['uid', 'name', 'short_name', 'code', 'definition', 'numerator_description', 'numerator_formula', 'denominator_description', 'denominator_formula', 'indicator_type', 'annualized', 'use_and_context', 'frequency', 'level', 'favorite', 'nids_versions'], 'safe'],
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
        $query = Indicators::find();

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
            'indicator_group_id' => $this->indicator_group_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['ilike', 'uid', $this->uid])
            ->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'short_name', $this->short_name])
            ->andFilterWhere(['ilike', 'code', $this->code])
            ->andFilterWhere(['ilike', 'definition', $this->definition])
            ->andFilterWhere(['ilike', 'numerator_description', $this->numerator_description])
            ->andFilterWhere(['ilike', 'numerator_formula', $this->numerator_formula])
            ->andFilterWhere(['ilike', 'denominator_description', $this->denominator_description])
            ->andFilterWhere(['ilike', 'denominator_formula', $this->denominator_formula])
            ->andFilterWhere(['ilike', 'indicator_type', $this->indicator_type])
            ->andFilterWhere(['ilike', 'annualized', $this->annualized])
            ->andFilterWhere(['ilike', 'use_and_context', $this->use_and_context])
            ->andFilterWhere(['ilike', 'frequency', $this->frequency])
            ->andFilterWhere(['ilike', 'level', $this->level])
            ->andFilterWhere(['ilike', 'favorite', $this->favorite])
            ->andFilterWhere(['ilike', 'nids_versions', $this->nids_versions]);

        return $dataProvider;
    }
}
