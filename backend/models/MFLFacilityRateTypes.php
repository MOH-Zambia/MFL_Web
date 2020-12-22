<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "MFL_Facility_rate_types".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 *
 * @property MFLFacilityRatings[] $mFLFacilityRatings
 */
class MFLFacilityRateTypes extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'MFL_Facility_rate_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string'],
            [['name'], 'unique', 'message' => 'Facility rate type exist already!'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[MFLFacilityRatings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMFLFacilityRatings() {
        return $this->hasMany(MFLFacilityRatings::className(), ['rate_type_id' => 'id']);
    }

      public static function getNames() {
        $names = self::find()->orderBy(['name' => SORT_ASC])->all();
        return ArrayHelper::map($names, 'name', 'name');
    }

    public static function getList() {
        $list = self::find()->orderBy(['name' => SORT_ASC])->all();
        return ArrayHelper::map($list, 'id', 'name');
    }

    public static function getById($id) {
        $data = self::find()->where(['id' => $id])->one();
        return $data->name;
    }
}
