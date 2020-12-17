<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\RightAllocation;
use backend\models\User;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Role */

$this->title = "Role: " . $model->role;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->role;
\yii\web\YiiAsset::register($this);
?>
<div class="card card-primary card-outline">
    <div class="card-body">

        <p>
            <?php
            if (User::userIsAllowedTo('Manage Roles')) {
                echo Html::a('<i class="fas fa-pencil-alt fa-2x"></i>', ['update', 'id' => $model->id], [
                    'title' => 'Update role',
                    'data-placement' => 'top',
                    'data-toggle' => 'tooltip'
                ]);

                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                echo Html::a('<i class="fas fa-trash fa-2x"></i>', ['delete', 'id' => $model->id], [
                    'title' => 'Remove role',
                    'data-placement' => 'top',
                    'data-toggle' => 'tooltip',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete ' . $model->role . ' role?<br>'
                        . 'Role will only be removed if no user is assigned the role!',
                        'method' => 'post',
                    ],
                ]);
            }
            ?>
        </p>
        <?php
        //This is a hack, just to use pjax for the delete confirm button
        $query = User::find()->where(['id' => '-2']);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);
        GridView::widget([
            'dataProvider' => $dataProvider,
        ]);
        ?>
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'role:ntext',
                [
                    'label' => 'Rights',
                    'value' => function($model) {
                        $rightsArray = RightAllocation::getRights($model->id);
                        return implode(", ", $rightsArray);
                    }
                ],
                [
                    'attribute' => 'created_by',
                    'value' => function($model) {
                        return !empty($model->created_by) ? User::findOne(['id' => $model->created_by])->getFullName() : "";
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'value' => function($model) {
                        return date('d-M-Y', $model->created_at);
                    }
                ],
                [
                    'label' => 'Last Modified By',
                    'value' => function($model) {
                        return !empty($model->updated_by) ? User::findOne(['id' => $model->updated_by])->getFullName() : "";
                    }
                ],
                [
                    'label' => 'Last Modified At',
                    'value' => function($model) {
                        return date('d-M-Y', $model->created_at);
                    }
                ],
            ],
        ])
        ?>
    </div>

</div>
