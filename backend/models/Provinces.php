<?php

namespace backend\models;

use yii\helpers\ArrayHelper;
use dosamigos\google\maps\LatLng;
/**
 * This is the model class for table "geography_province".
 *
 * @property int $id
 * @property string $name
 * @property int $population
 * @property float $pop_density
 * @property float $area_sq_km
 * @property string $geom
 *
 * @property GeographyDistrict[] $geographyDistricts
 */
class Provinces extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'geography_province';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'population', 'pop_density', 'area_sq_km'], 'required'],
            [['population'], 'default', 'value' => null],
            [['population'], 'integer'],
            [['pop_density', 'area_sq_km'], 'number'],
            [['geom'], 'safe'],
            [['name'], 'string', 'max' => 64],
            ['name', 'unique', 'message' => 'Province name exist already!'],
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
            'area_sq_km' => 'Area',
            'geom' => 'Geometry',
        ];
    }

    /**
     * Gets query for [[GeographyDistricts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGeographyDistricts() {
        return $this->hasMany(GeographyDistrict::className(), ['province_id' => 'id']);
    }

    public static function getProvinceList() {
        $provinces = self::find()->orderBy(['name' => SORT_ASC])->all();
        $list = ArrayHelper::map($provinces, 'id', 'name');
        return $list;
    }

    public static function getProvinceNames() {
        $provinces = self::find()->orderBy(['name' => SORT_ASC])->all();
        $list = ArrayHelper::map($provinces, 'name', 'name');
        return $list;
    }

    public static function getProvinceById($id) {
        $province = self::find()->where(['id' => $id])->one();
        return $province->name;
    }

    public static function getCoordinates($coordinate_array) {
        $coordinates = [];
        foreach ($coordinate_array[0][0] as $coordinate) {
            array_push($coordinates, new LatLng(['lat' => $coordinate[1], 'lng' => $coordinate[0]]));
        }
        return $coordinates;
    }

}
