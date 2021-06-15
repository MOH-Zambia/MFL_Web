<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "right_allocation".
 *
 * @property int $id
 * @property int $role
 * @property int $right
 * @property int $created_at
 * @property int $created_by
 *
 * @property Role $role0
 */
class RightAllocation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aauth_group_permissions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role', 'right'], 'required'],
            [['role'], 'integer'],
            [['right'], 'string'],
            [['role'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role' => 'Role',
            'right' => 'Right',
            //'created_at' => 'Created At',
           // 'created_by' => 'Created By',
        ];
    }

    /**
     * {@inheritdoc}
     */
   /* public function behaviors() {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRight0()
    {
        return $this->hasOne(Right::className(), ['id' => 'right']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole0()
    {
        return $this->hasOne(Role::className(), ['id' => 'role']);
    }
    
    public static function getRights($roleid) {
        $rights = self::find()
                ->where(['role' => $roleid])
                ->all();
        
        return \yii\helpers\ArrayHelper::map($rights, 'right', 'right');
    }
}
