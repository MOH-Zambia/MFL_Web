<?php

namespace common\models;

use backend\models\User;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "role".
 *
 * @property int $id
 * @property string $role
 * @property int $created_at
 * @property int $updated_at
 * @property int $updated_by
 * @property int $created_by
 *
 * @property HeaUser[] $heaUsers
 * @property HeiUser[] $heiUsers
 * @property RightAllocation[] $rightAllocations
 */
class Role extends ActiveRecord {

    public $rights;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'aauth_groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['role'], 'required'],
            [['role'], 'unique', 'message' => "Role exists already!"],
            [['created_at', 'updated_at', 'updated_by', 'created_by'], 'integer'],
            [['role'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
            'role' => 'Role name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeaUsers() {
        return $this->hasMany(HeaUser::className(), ['role' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeiUsers() {
        return $this->hasMany(HeiUser::className(), ['role' => 'id']);
    }

    /**
     * @return array
     */
    public static function getRoleList() {
        $roles = self::find()->orderBy(['role' => SORT_ASC])->all();
        $list = ArrayHelper::map($roles, 'role', 'role');
        return $list;
    }

    public static function getRoles() {
        $roles = self::find()
                       ->orderBy(['role' => SORT_ASC])->all();
        $list = ArrayHelper::map($roles, 'id', 'role');
        return $list;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getRoleById($id) {
        $role = self::find()->where(['id' => $id])->one();
        return $role->role;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRightAllocations() {
        return $this->hasMany(RightAllocation::className(), ['role' => 'id']);
    }

}
