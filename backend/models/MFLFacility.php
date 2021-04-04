<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "MFL_facility".
 *
 * @property int $id
 * @property string|null $DHIS2_UID
 * @property string|null $HMIS_code
 * @property string|null $smartcare_GUID
 * @property string|null $eLMIS_ID
 * @property string|null $iHRIS_ID
 * @property string $name
 * @property int|null $number_of_beds
 * @property int|null $number_of_cots
 * @property int|null $number_of_nurses
 * @property int|null $number_of_doctors
 * @property string|null $address_line1
 * @property string|null $address_line2
 * @property string|null $postal_address
 * @property string|null $web_address
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $fax
 * @property int|null $catchment_population_head_count
 * @property int|null $catchment_population_cso
 * @property string|null $star
 * @property string|null $rated
 * @property string|null $rating
 * @property float|null $longitude
 * @property float|null $latitude
 * @property string|null $comment
 * @property string|null $geom
 * @property string $timestamp
 * @property string $updated
 * @property string|null $slug
 * @property int|null $administrative_unit_id
 * @property int|null $constituency_id
 * @property int $district_id
 * @property int $facility_type_id
 * @property int|null $location_type_id
 * @property int $operation_status_id
 * @property int $ownership_id
 * @property int|null $ward_id
 *
 * @property MFLAdministrativeunit $administrativeUnit
 * @property MFLFacilitytype $facilityType
 * @property MFLOperationstatus $operationStatus
 * @property MFLOwnership $ownership
 * @property GeographyConstituency $constituency
 * @property GeographyDistrict $district
 * @property GeographyLocationtype $locationType
 * @property GeographyWard $ward
 * @property MFLFacilityEquipment[] $mFLFacilityEquipments
 * @property MFLEquipment[] $equipment
 * @property MFLFacilityInfrastructure[] $mFLFacilityInfrastructures
 * @property MFLInfrastructure[] $infrastructures
 * @property MFLFacilityLabLevel[] $mFLFacilityLabLevels
 * @property MFLLablevel[] $lablevels
 * @property MFLFacilityOperatingHours[] $mFLFacilityOperatingHours
 * @property MFLOperatinghours[] $operatinghours
 * @property MFLFacilityServices[] $mFLFacilityServices
 * @property MFLService[] $services
 */
class MFLFacility extends \yii\db\ActiveRecord {

    public $province_id;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'MFL_facility';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name', 'timestamp', 'updated', 'district_id', 'facility_type_id', 'operation_status_id', 'ownership_id'], 'required'],
            [['number_of_beds', 'number_of_cots', 'number_of_nurses', 'number_of_doctors', 'catchment_population_head_count', 'catchment_population_cso', 'administrative_unit_id', 'constituency_id', 'district_id', 'facility_type_id', 'location_type_id', 'operation_status_id', 'ownership_id', 'ward_id'], 'default', 'value' => null],
            [['number_of_beds', 'number_of_cots', 'number_of_nurses', 'number_of_doctors', 'catchment_population_head_count', 'catchment_population_cso', 'administrative_unit_id', 'constituency_id', 'district_id', 'facility_type_id', 'location_type_id', 'operation_status_id', 'ownership_id', 'ward_id'], 'integer'],
            [['star', 'rated', 'rating', 'comment',], 'string'],
            [['longitude', 'latitude'], 'number'],
            [['timestamp', 'updated', 'province_id', 'geom'], 'safe'],
            [['DHIS2_UID', 'eLMIS_ID', 'iHRIS_ID', 'phone', 'mobile', 'fax'], 'string', 'max' => 13],
            [['HMIS_code'], 'string', 'max' => 10],
            [['smartcare_GUID'], 'string', 'max' => 36],
            [['name'], 'string', 'max' => 100],
            [['address_line1', 'address_line2'], 'string', 'max' => 60],
            [['postal_address'], 'string', 'max' => 25],
            [['web_address'], 'string', 'max' => 200],
            [['email', 'slug'], 'string', 'max' => 254],
            [['email'], 'email'],
            [['administrative_unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => MFLAdministrativeunit::className(), 'targetAttribute' => ['administrative_unit_id' => 'id']],
            [['facility_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Facilitytype::className(), 'targetAttribute' => ['facility_type_id' => 'id']],
            [['operation_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operationstatus::className(), 'targetAttribute' => ['operation_status_id' => 'id']],
            [['ownership_id'], 'exist', 'skipOnError' => true, 'targetClass' => FacilityOwnership::className(), 'targetAttribute' => ['ownership_id' => 'id']],
            [['constituency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Constituency::className(), 'targetAttribute' => ['constituency_id' => 'id']],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => Districts::className(), 'targetAttribute' => ['district_id' => 'id']],
            [['location_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => LocationType::className(), 'targetAttribute' => ['location_type_id' => 'id']],
            [['ward_id'], 'exist', 'skipOnError' => true, 'targetClass' => Wards::className(), 'targetAttribute' => ['ward_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'DHIS2_UID' => 'DHIS2 UID',
            'HMIS_code' => 'HMIS Code',
            'smartcare_GUID' => 'SMARTCARE GUID',
            'eLMIS_ID' => 'ELMIS ID',
            'iHRIS_ID' => 'IHRIS ID',
            'name' => 'Name',
            'number_of_beds' => 'Number Of Beds',
            'number_of_cots' => 'Number Of Cots',
            'number_of_nurses' => 'Number Of Nurses',
            'number_of_doctors' => 'Number Of Doctors',
            'address_line1' => 'Address 1',
            'address_line2' => 'Address 2',
            'postal_address' => 'Postal address',
            'web_address' => 'Web address',
            'email' => 'Email',
            'phone' => 'Phone',
            'mobile' => 'Mobile',
            'fax' => 'Fax',
            'catchment_population_head_count' => 'Catchment population head count',
            'catchment_population_cso' => 'Catchment population cso',
            // 'star' => 'Star',
            // 'rated' => 'Rated',
            //  'rating' => 'Rating',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
            'comment' => 'Comment',
            'geom' => 'Geom',
            'timestamp' => 'Timestamp',
            'updated' => 'Updated',
            'slug' => 'Slug',
            'administrative_unit_id' => 'Administrative unit',
            'constituency_id' => 'Constituency',
            'district_id' => 'District',
            'province_id' => 'Province',
            'facility_type_id' => 'Facility type',
            'location_type_id' => 'Location type',
            'operation_status_id' => 'Operation status',
            'ownership_id' => 'Ownership',
            'ward_id' => 'Ward',
        ];
    }

    /**
     * Gets query for [[AdministrativeUnit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdministrativeUnit() {
        return $this->hasOne(MFLAdministrativeunit::className(), ['id' => 'administrative_unit_id']);
    }

    /**
     * Gets query for [[FacilityType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFacilityType() {
        return $this->hasOne(Facilitytype::className(), ['id' => 'facility_type_id']);
    }

    /**
     * Gets query for [[OperationStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOperationStatus() {
        return $this->hasOne(Operationstatus::className(), ['id' => 'operation_status_id']);
    }

    /**
     * Gets query for [[Ownership]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwnership() {
        return $this->hasOne(FacilityOwnership::className(), ['id' => 'ownership_id']);
    }

    /**
     * Gets query for [[Constituency]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConstituency() {
        return $this->hasOne(Constituency::className(), ['id' => 'constituency_id']);
    }

    /**
     * Gets query for [[District]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict() {
        return $this->hasOne(Districts::className(), ['id' => 'district_id']);
    }

    /**
     * Gets query for [[LocationType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLocationType() {
        return $this->hasOne(LocationType::className(), ['id' => 'location_type_id']);
    }

    /**
     * Gets query for [[Ward]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWard() {
        return $this->hasOne(Wards::className(), ['id' => 'ward_id']);
    }

    /**
     * Gets query for [[MFLFacilityEquipments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMFLFacilityEquipments() {
        return $this->hasMany(MFLFacilityEquipment::className(), ['facility_id' => 'id']);
    }

    /**
     * Gets query for [[Equipment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipment() {
        return $this->hasMany(Equipment::className(), ['id' => 'equipment_id'])->viaTable('MFL_facility_equipment', ['facility_id' => 'id']);
    }

    /**
     * Gets query for [[MFLFacilityInfrastructures]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMFLFacilityInfrastructures() {
        return $this->hasMany(MFLFacilityInfrastructure::className(), ['facility_id' => 'id']);
    }

    /**
     * Gets query for [[Infrastructures]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInfrastructures() {
        return $this->hasMany(MFLInfrastructure::className(), ['id' => 'infrastructure_id'])->viaTable('MFL_facility_infrastructure', ['facility_id' => 'id']);
    }

    /**
     * Gets query for [[MFLFacilityLabLevels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMFLFacilityLabLevels() {
        return $this->hasMany(MFLFacilityLabLevel::className(), ['facility_id' => 'id']);
    }

    /**
     * Gets query for [[Lablevels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLablevels() {
        return $this->hasMany(MFLLablevel::className(), ['id' => 'lablevel_id'])->viaTable('MFL_facility_lab_level', ['facility_id' => 'id']);
    }

    /**
     * Gets query for [[MFLFacilityOperatingHours]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMFLFacilityOperatingHours() {
        return $this->hasMany(MFLFacilityOperatingHours::className(), ['facility_id' => 'id']);
    }

    /**
     * Gets query for [[Operatinghours]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOperatinghours() {
        return $this->hasMany(Operatinghours::className(), ['id' => 'operatinghours_id'])->viaTable('MFL_facility_operating_hours', ['facility_id' => 'id']);
    }

    /**
     * Gets query for [[MFLFacilityServices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMFLFacilityServices() {
        return $this->hasMany(MFLFacilityServices::className(), ['facility_id' => 'id']);
    }

    /**
     * Gets query for [[Services]].
     *
     * @return \yii\db\ActiveQuery
     */
    public static function getServices() {
        return $this->hasMany(FacilityService::className(), ['id' => 'service_id'])->viaTable('MFL_facility_services', ['facility_id' => 'id']);
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

    public static function getCoordinates($coordinates) {
        return new LatLng(['lat' => $coordinate[1], 'lng' => $coordinate[0]]);
    }

}
