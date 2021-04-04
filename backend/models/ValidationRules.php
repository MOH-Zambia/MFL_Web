<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "validation_rules".
 *
 * @property int $id
 * @property string $uid
 * @property string $name
 * @property string $operator
 * @property string|null $description
 * @property string|null $left_side
 * @property string|null $right_side
 * @property string|null $type
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 */
class ValidationRules extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'validation_rules';
    }

    public static function getDb() {
        return Yii::$app->db1;
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['uid', 'name', 'operator'], 'required'],
            [['uid', 'name', 'description', 'left_side', 'right_side', 'type'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'created_by', 'updated_by', 'operator',], 'integer'],
            ['name', 'unique', 'when' => function($model) {
                    return $model->isAttributeChanged('name');
                }, 'message' => 'Validation rule name exist already!'],
            [['operator'], 'exist', 'skipOnError' => true, 'targetClass' => ValidationRuleOperator::className(), 'targetAttribute' => ['operator' => 'id']],
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
            'operator' => 'Operator',
            'description' => 'Description',
            'left_side' => 'Left Side',
            'right_side' => 'Right Side',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    public static function getList() {
        $provinces = self::find()->orderBy(['name' => SORT_ASC])->all();
        $list = \yii\helpers\ArrayHelper::map($provinces, 'id', 'name');
        return $list;
    }

}
