<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "validation_rule_operator".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 */
class ValidationRuleOperator extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'validation_rule_operator';
    }

    public static function getDb() {
        return Yii::$app->db1;
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string'],
            ['name', 'unique', 'message' => 'Validation rule operator name exist already!'],
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

    public static function getList() {
        $provinces = self::find()->orderBy(['name' => SORT_ASC])->all();
        $list = ArrayHelper::map($provinces, 'id', 'name');
        return $list;
    }

}
