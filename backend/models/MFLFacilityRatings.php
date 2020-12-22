<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "MFL_Facility_ratings".
 *
 * @property int $id
 * @property int $rate_type_id
 * @property string $rating
 * @property string|null $email
 * @property string|null $comment
 * @property int|null $date_created
 * @property int $facility_id
 *
 * @property MFLFacilityRateTypes $rateType
 */
class MFLFacilityRatings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'MFL_Facility_ratings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'rate_type_id', 'rating', 'facility_id'], 'required'],
            [['id', 'rate_type_id', 'date_created', 'facility_id'], 'default', 'value' => null],
            [['id', 'rate_type_id', 'date_created', 'facility_id','rate_value'], 'integer'],
            [['rating', 'email', 'comment'], 'string'],
            [['id'], 'unique'],
            [['rate_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => MFLFacilityRateTypes::className(), 'targetAttribute' => ['rate_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rate_type_id' => 'Rate type',
            'rating' => 'Rating',
            'email' => 'Email',
            'comment' => 'Comment',
            'date_created' => 'Date rated',
            'facility_id' => 'Facility',
            'rate_value' => 'Rate value',
        ];
    }

    /**
     * Gets query for [[RateType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRateType()
    {
        return $this->hasOne(MFLFacilityRateTypes::className(), ['id' => 'rate_type_id']);
    }
}
