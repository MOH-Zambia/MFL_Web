<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "indicators".
 *
 * @property int $id
 * @property string $uid
 * @property string $name
 * @property string $short_name
 * @property string $code
 * @property string|null $definition
 * @property int $indicator_group_id
 * @property string|null $numerator_description
 * @property string|null $numerator_formula
 * @property string|null $denominator_description
 * @property string|null $denominator_formula
 * @property string|null $indicator_type
 * @property string|null $annualized
 * @property string|null $use_and_context
 * @property string|null $frequency
 * @property string|null $level
 * @property string|null $favorite
 * @property string|null $nids_versions
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property IndicatorGroup $indicatorGroup
 */
class Indicators extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'indicators';
    }

    public static function getDb() {
        return Yii::$app->db1;
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['uid', 'name', 'short_name', 'code', 'indicator_group_id'], 'required'],
            [['uid', 'name', 'short_name', 'code', 'definition', 'numerator_description', 'numerator_formula', 'denominator_description', 'denominator_formula', 'indicator_type', 'annualized', 'use_and_context', 'frequency', 'level', 'favorite', 'nids_versions'], 'string'],
            [['indicator_group_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            ['name', 'unique', 'when' => function($model) {
                    return $model->isAttributeChanged('name');
                }, 'message' => 'Validation rule name exist already!'],
            ['code', 'unique', 'when' => function($model) {
                    return $model->isAttributeChanged('code');
                }, 'message' => 'Validation rule name exist already!'],
            [['indicator_group_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['indicator_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => IndicatorGroup::className(), 'targetAttribute' => ['indicator_group_id' => 'id']],
        ];
    }

    public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'uid' => 'UID',
            'name' => 'Name',
            'short_name' => 'ShortName',
            'code' => 'Code',
            'definition' => 'Definition',
            'indicator_group_id' => 'Indicator group',
            'numerator_description' => 'Numerator description',
            'numerator_formula' => 'Numerator',
            'denominator_description' => 'Denominator description',
            'denominator_formula' => 'Denominator',
            'indicator_type' => 'Indicator type',
            'annualized' => 'Annualized',
            'use_and_context' => 'UseAndContext',
            'frequency' => 'Frequency',
            'level' => 'Level',
            'favorite' => 'Favorite',
            'nids_versions' => 'Nids Versions',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[IndicatorGroup]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIndicatorGroup() {
        return $this->hasOne(IndicatorGroup::className(), ['id' => 'indicator_group_id']);
    }

    public static function getList() {
        $provinces = self::find()->orderBy(['name' => SORT_ASC])->all();
        $list = \yii\helpers\ArrayHelper::map($provinces, 'id', 'name');
        return $list;
    }

}
