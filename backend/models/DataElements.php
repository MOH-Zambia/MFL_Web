<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "data_elements".
 *
 * @property int $id
 * @property int $element_group_id
 * @property string $uid
 * @property string $name
 * @property string $short_name
 * @property string $code
 * @property string|null $definition
 * @property string|null $aggregation_type
 * @property string|null $domain_type
 * @property string|null $description
 * @property string|null $definition_extended
 * @property string|null $use_and_context
 * @property string|null $inclusions
 * @property string|null $exclusions
 * @property string|null $collected_by
 * @property string|null $collection_point
 * @property string|null $tools
 * @property string|null $keep_zero_values
 * @property string|null $zeroissignificant
 * @property string|null $nids_versions
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property DataElementGroup $id0
 */
class DataElements extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'data_elements';
    }

    public static function getDb() {
        return Yii::$app->db1;
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['element_group_id', 'uid', 'name', 'short_name', 'code'], 'required'],
            [['element_group_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['element_group_id', 'created_by', 'updated_by'], 'integer'],
            ['name', 'unique', 'when' => function($model) {
                    return $model->isAttributeChanged('name');
                }, 'message' => 'Validation rule name exist already!'],
            ['code', 'unique', 'when' => function($model) {
                    return $model->isAttributeChanged('code');
                }, 'message' => 'Validation rule name exist already!'],
            [['uid', 'name', 'short_name', 'code', 'definition', 'aggregation_type',
            'domain_type', 'description', 'definition_extended', 'use_and_context',
            'inclusions', 'exclusions', 'collected_by', 'collection_point', 'tools',
            'keep_zero_values', 'zeroissignificant', 'nids_versions','favorite'], 'string'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => DataElementGroup::className(), 'targetAttribute' => ['id' => 'id']],
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
            'element_group_id' => 'Data element group',
            'uid' => 'UID',
            'name' => 'Name',
            'short_name' => 'Short name',
            'code' => 'Code',
            'definition' => 'Definition',
            'aggregation_type' => 'Aggregation type',
            'domain_type' => 'Domain type',
            'description' => 'Description',
            'favorite' => 'Favorite',
            'definition_extended' => 'Definition extended',
            'use_and_context' => 'Use and Context',
            'inclusions' => 'Inclusions',
            'exclusions' => 'Exclusions',
            'collected_by' => 'Collected by',
            'collection_point' => 'Collection point',
            'tools' => 'Tools',
            'keep_zero_values' => 'Keep zero values',
            'zeroissignificant' => 'Zero is significant',
            'nids_versions' => 'Nids Versions',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getId0() {
        return $this->hasOne(DataElementGroup::className(), ['id' => 'id']);
    }

    public static function getList() {
        $provinces = self::find()->orderBy(['name' => SORT_ASC])->all();
        $list = \yii\helpers\ArrayHelper::map($provinces, 'id', 'name');
        return $list;
    }

}
