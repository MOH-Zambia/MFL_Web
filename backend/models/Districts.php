<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use dosamigos\google\maps\LatLng;

/**
 * This is the model class for table "geography_district".
 *
 * @property int $id
 * @property string $name
 * @property float|null $population
 * @property float|null $pop_density
 * @property float|null $area_sq_km
 * @property string $geom
 * @property int $district_type_id
 * @property int $province_id
 *
 * @property MFLFacility[] $mFLFacilities
 * @property GeographyConstituency[] $geographyConstituencies
 * @property GeographyDistricttype $districtType
 * @property GeographyProvince $province
 */
class Districts extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'geography_district';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'geom', 'district_type_id', 'province_id'], 'required'],
            [['population', 'pop_density', 'area_sq_km'], 'number'],
            [['geom'], 'safe'],
            [['district_type_id', 'province_id'], 'default', 'value' => null],
            [['district_type_id', 'province_id'], 'integer'],
            [['name'], 'string', 'max' => 30],
            ['name', 'unique', 'when' => function($model) {
                    return $model->isAttributeChanged('name') &&
                            empty($model->province_id) ? TRUE : FALSE;
                }, 'message' => 'District name already exist!'],
            ['name', 'unique', 'when' => function($model) {
                    return $model->isAttributeChanged('name') && !empty(self::findOne(['name' => $model->name, "province_id" => $model->province_id])) ? TRUE : FALSE;
                }, 'message' => 'District name already exist for this province!'],
            ['name', 'unique', 'when' => function($model) {
                    return $model->isAttributeChanged('name') &&
                            !empty(self::findOne([
                                        'name' => $model->name,
                                        "province_id" => $model->province_id,
                                        "district_type_id" => $model->district_type_id])) ? TRUE : FALSE;
                }, 'message' => 'District name already exist for this Province and District type!'],
            [['district_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => DistrictType::className(), 'targetAttribute' => ['district_type_id' => 'id']],
            [['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provinces::className(), 'targetAttribute' => ['province_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'population' => 'Population',
            'pop_density' => 'Population Density',
            'area_sq_km' => 'Area Sq Km',
            'geom' => 'Geometry Coordinates',
            'district_type_id' => 'District type',
            'province_id' => 'Province',
        ];
    }

    /**
     * Gets query for [[MFLFacilities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMFLFacilities() {
        return $this->hasMany(MFLFacility::className(), ['district_id' => 'id']);
    }

    /**
     * Gets query for [[GeographyConstituencies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGeographyConstituencies() {
        return $this->hasMany(Constituency::className(), ['district_id' => 'id']);
    }

    /**
     * Gets query for [[DistrictType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistrictType() {
        return $this->hasOne(DistrictType::className(), ['id' => 'district_type_id']);
    }

    /**
     * Gets query for [[Province]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvince() {
        return $this->hasOne(Provinces::className(), ['id' => 'province_id']);
    }

    public static function getNames() {
        $names = self::find()->orderBy(['name' => SORT_ASC])->all();
        return ArrayHelper::map($names, 'name', 'name');
    }

    public static function getList() {
        $list = self::find()->orderBy(['name' => SORT_ASC])->all();
        return ArrayHelper::map($list, 'id', 'name');
    }

    public static function getListByProvinceID($id) {
        $list = self::find()->where(['province_id' => $id])->orderBy(['name' => SORT_ASC])->all();
        return ArrayHelper::map($list, 'id', 'name');
    }

    public static function getById($id) {
        $data = self::find()->where(['id' => $id])->one();
        return $data->name;
    }

    public static function getCoordinates($coordinate_array) {
        $coordinates = [];
        foreach ($coordinate_array[0][0] as $coordinate) {
            array_push($coordinates, new LatLng(['lat' => $coordinate[1], 'lng' => $coordinate[0]]));
        }
        return $coordinates;
    }

}
