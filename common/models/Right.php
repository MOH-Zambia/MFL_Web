<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "right".
 *
 * @property int $id
 * @property string $right
 */
class Right extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'aauth_permissions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['right'], 'string', 'max' => 255],
            //[['active'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'right' => 'Right',
            
        ];
    }

    public static function getAllRights() {
        $query = self::find()->all();
        return $query;
    }

    public static function getRightList() {
        $rights = self::find()->orderBy(['name' => SORT_ASC])->all();
        $list = ArrayHelper::map($rights, 'right', 'right');
        return $list;
    }

    public static function getRightList1() {
        $rights = self::find()->orderBy(['right' => SORT_ASC])->all();
        $list = ArrayHelper::map($rights, 'id', 'right');
        return $list;
    }

}
