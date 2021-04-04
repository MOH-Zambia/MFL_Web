<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "indicator_group".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 *
 * @property Indicators[] $indicators
 */
class IndicatorGroup extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'indicator_group';
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
            ['name', 'unique', 'message' => 'Indicator group name exist already!'],
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
     * Gets query for [[Indicators]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIndicators() {
        return $this->hasMany(Indicators::className(), ['indicator_group_id' => 'id']);
    }

    public static function getList() {
        $provinces = self::find()->orderBy(['name' => SORT_ASC])->all();
        $list = ArrayHelper::map($provinces, 'id', 'name');
        return $list;
    }

}
