<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ValidationRules;
use Yii;
/**
 * ValidationRulesSearch represents the model behind the search form of `backend\models\ValidationRules`.
 */
class ValidationRulesSearch1 extends ValidationRules
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['uid', 'name', 'operator', 'description', 'left_side', 'right_side', 'type'], 'safe'],
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
        $query = ValidationRules::find()->cache(Yii::$app->params['cache_duration']);

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'operator' => $this->operator,
        ]);

        $query->andFilterWhere(['ilike', 'uid', $this->uid])
            ->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'description', $this->description])
            ->andFilterWhere(['ilike', 'left_side', $this->left_side])
            ->andFilterWhere(['ilike', 'right_side', $this->right_side])
            ->andFilterWhere(['ilike', 'type', $this->type]);

        return $dataProvider;
    }
}
