<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\DataElements;

/**
 * DataElementsSearch represents the model behind the search form of `backend\models\DataElements`.
 */
class DataElementsSearch extends DataElements
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'element_group_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['uid', 'name', 'short_name', 'code', 'definition', 'aggregation_type', 'domain_type', 
                'description', 'definition_extended', 'use_and_context', 'inclusions', 'exclusions', 
                'collected_by', 'collection_point', 'tools', 'keep_zero_values', 'zeroissignificant',
                'nids_versions','favorite'], 'safe'],
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
        $query = DataElements::find();

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
            'element_group_id' => $this->element_group_id,
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
            ->andFilterWhere(['ilike', 'favorite', $this->favorite])
            ->andFilterWhere(['ilike', 'aggregation_type', $this->aggregation_type])
            ->andFilterWhere(['ilike', 'domain_type', $this->domain_type])
            ->andFilterWhere(['ilike', 'description', $this->description])
            ->andFilterWhere(['ilike', 'definition_extended', $this->definition_extended])
            ->andFilterWhere(['ilike', 'use_and_context', $this->use_and_context])
            ->andFilterWhere(['ilike', 'inclusions', $this->inclusions])
            ->andFilterWhere(['ilike', 'exclusions', $this->exclusions])
            ->andFilterWhere(['ilike', 'collected_by', $this->collected_by])
            ->andFilterWhere(['ilike', 'collection_point', $this->collection_point])
            ->andFilterWhere(['ilike', 'tools', $this->tools])
            ->andFilterWhere(['ilike', 'keep_zero_values', $this->keep_zero_values])
            ->andFilterWhere(['ilike', 'zeroissignificant', $this->zeroissignificant])
            ->andFilterWhere(['ilike', 'nids_versions', $this->nids_versions]);

        return $dataProvider;
    }
}
