<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "data_element_group".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 *
 * @property DataElements $dataElements
 */
class DataElementGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'data_element_group';
    }
    
    public static function getDb() {
        return Yii::$app->db1;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string'],
             ['name', 'unique', 'message' => 'Data element group name exist already!'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[DataElements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDataElements()
    {
        return $this->hasOne(DataElements::className(), ['id' => 'id']);
    }
    
     public static function getList() {
        $provinces = self::find()->orderBy(['name' => SORT_ASC])->all();
        $list = ArrayHelper::map($provinces, 'id', 'name');
        return $list;
    }
}
