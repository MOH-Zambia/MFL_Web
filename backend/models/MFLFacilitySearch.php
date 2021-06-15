<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\MFLFacility;

/**
 * MFLFacilitySearch represents the model behind the search form of `backend\models\MFLFacility`.
 */
class MFLFacilitySearch extends MFLFacility
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'number_of_beds', 'number_of_cots', 'number_of_nurses', 'number_of_doctors','number_of_paramedics','number_of_midwives', 'catchment_population_head_count', 'catchment_population_cso', 'administrative_unit_id', 'constituency_id', 'district_id', 'facility_type_id', 'location_type_id', 'operation_status_id', 'ownership_id', 'ward_id'], 'integer'],
            [['DHIS2_UID', 'HMIS_code', 'smartcare_GUID', 'eLMIS_ID', 'iHRIS_ID', 'name', 'address_line1', 'address_line2', 'postal_address', 'web_address', 'email', 'phone', 'mobile', 'fax', 'star', 'rated', 'rating', 'comment', 'geom', 'timestamp', 'updated', 'slug','province_id'], 'safe'],
            [['longitude', 'latitude'], 'number'],
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
        $query = MFLFacility::find();

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
            'number_of_beds' => $this->number_of_beds,
            'number_of_cots' => $this->number_of_cots,
            'number_of_nurses' => $this->number_of_nurses,
            'number_of_doctors' => $this->number_of_doctors,
            'number_of_paramedics'=> $this->number_of_paramedics,
            'number_of_midwives'=> $this->number_of_midwives,
            'catchment_population_head_count' => $this->catchment_population_head_count,
            'catchment_population_cso' => $this->catchment_population_cso,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'timestamp' => $this->timestamp,
            'updated' => $this->updated,
            'administrative_unit_id' => $this->administrative_unit_id,
            'constituency_id' => $this->constituency_id,
            'district_id' => $this->district_id,
            'facility_type_id' => $this->facility_type_id,
            'location_type_id' => $this->location_type_id,
            'operation_status_id' => $this->operation_status_id,
            'ownership_id' => $this->ownership_id,
            'ward_id' => $this->ward_id,
        ]);

        $query->andFilterWhere(['ilike', 'DHIS2_UID', $this->DHIS2_UID])
            ->andFilterWhere(['ilike', 'HMIS_code', $this->HMIS_code])
            ->andFilterWhere(['ilike', 'smartcare_GUID', $this->smartcare_GUID])
            ->andFilterWhere(['ilike', 'eLMIS_ID', $this->eLMIS_ID])
            ->andFilterWhere(['ilike', 'iHRIS_ID', $this->iHRIS_ID])
            ->andFilterWhere(['ilike', 'name', $this->name])
            ->andFilterWhere(['ilike', 'address_line1', $this->address_line1])
            ->andFilterWhere(['ilike', 'address_line2', $this->address_line2])
            ->andFilterWhere(['ilike', 'postal_address', $this->postal_address])
            ->andFilterWhere(['ilike', 'web_address', $this->web_address])
            ->andFilterWhere(['ilike', 'email', $this->email])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'mobile', $this->mobile])
            ->andFilterWhere(['ilike', 'fax', $this->fax])
            ->andFilterWhere(['ilike', 'star', $this->star])
            ->andFilterWhere(['ilike', 'rated', $this->rated])
            ->andFilterWhere(['ilike', 'rating', $this->rating])
            ->andFilterWhere(['ilike', 'comment', $this->comment])
            ->andFilterWhere(['ilike', 'geom', $this->geom])
            ->andFilterWhere(['ilike', 'slug', $this->slug]);
        return $dataProvider;
    }
}
