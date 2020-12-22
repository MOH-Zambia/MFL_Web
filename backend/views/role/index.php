<?php

use common\models\Role;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\ActionColumn;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RoleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-primary card-outline">
    <div class="card-body">
        <p>
            <?php
            if (User::userIsAllowedTo('Manage Roles')) {
                echo Html::a('<i class="fa fa-plus"></i> Add new role', ['create'], ['class' => 'btn btn-sm btn-primary']);
                echo '<hr class="dotted short">';
            }
            ?>
        </p>

        <div class="table-responsive">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'pjax' => TRUE,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'role',
                        'format' => 'raw',
                        'filterType' => GridView::FILTER_SELECT2,
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filter' => Role::getRoleList(),
                        'filterInputOptions' => ['prompt' => 'Filter by Role', 'class' => 'form-control', 'id' => null],
                    ],
                    [
                        'label' => 'Permissions',
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'max-width:300px;'],
                        'value' => function ($model) {

                            $rightsArray = \common\models\RightAllocation::getRights($model->id);
                            $rights = \implode(",", $rightsArray);

                            return $rights;
                        },
                    /* 'contentOptions' => function($model) {
                      // needs to be closure because of title
                      return [
                      'class' => 'cell-with-tooltip',
                      'data-toggle' => 'tooltip',
                      'data-placement' => 'bottom', // top, bottom, left, right
                      'data-container' => 'body', // to prevent breaking table on hover
                      'title' => $model->permissions,
                      ];
                      } */
                    ],
                    ['class' => ActionColumn::className(),
                        'options' => ['style' => 'width:130px;'],
                        'template' => '{view}{update}{delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a(
                                                '<span class="fa fa-eye"></span>', ['view', 'id' => $model->id], [
                                            'title' => 'View',
                                            'data-toggle' => 'tooltip',
                                            'data-placement' => 'top',
                                            'data-pjax' => '0',
                                            'style' => "padding:5px;",
                                            'class' => 'bt btn-lg'
                                                ]
                                );
                            },
                            'update' => function ($url, $model) {
                                if (User::userIsAllowedTo('Manage Roles')) {
                                    return Html::a(
                                                    '<span class="fas fa-edit"></span>', ['update', 'id' => $model->id], [
                                                'title' => 'update',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top',
                                                'data-pjax' => '0',
                                                'style' => "padding:5px;",
                                                'class' => 'bt btn-lg'
                                                    ]
                                    );
                                }
                            },
                            'delete' => function ($url, $model) {
                                if (User::userIsAllowedTo('Manage Roles')) {
                                    return Html::a(
                                                    '<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
                                                'title' => 'Delete',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top',
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to delete '.$model->role.' role?<br>'
                                                    . 'Role will only be removed if no user is assigned the role!',
                                                    'method' => 'post',
                                                ],
                                                'style' => "padding:5px;",
                                                'class' => 'bt btn-lg'
                                                    ]
                                    );
                                }
                            },
                        ]
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
