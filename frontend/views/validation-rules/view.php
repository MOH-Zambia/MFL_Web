<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ValidationRules */

$this->title = $model->uid;
$this->params['breadcrumbs'][] = ['label' => 'Validation rules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container-fluid">
    <!--DIV not to be removed-->    
    <div id="output"></div>
    <div class="row" style="margin-right:-50px;margin-left:-50px;">
        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-body">

                    <p class="float-right">
                        <?php
                        echo Html::a(
                                'Download: <i class="fas fa-file-pdf fa-2x"></i>',
                                ['/validation-rules/download', 'id' => $model->id], [
                            'title' => 'Download rule',
                            'target' => '_blank',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'data-pjax' => '0',
                            'style' => "padding:5px;",
                                ]
                        );
                        ?>
                    </p>
                    <?php
                    $attributes = [
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'uid',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'name',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'operator',
                                    'displayOnly' => true,
                                    'value' => !empty($model->operator) ? backend\models\ValidationRuleOperator::findOne($model->operator)->name : ""
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'description',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'left_side',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'right_side',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'type',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'label' => 'last updated',
                                    'value' => date('Y-m-d h:i:s', $model->updated_at)
                                ],
                            ],
                        ],
                    ];
                    echo DetailView::widget([
                        'model' => $model,
                        'attributes' => $attributes,
                        'mode' => DetailView::MODE_VIEW,
                        'condensed' => true,
                        'responsive' => true,
                        'hover' => true,
                        'hAlign' => DetailView::ALIGN_LEFT,
                        'vAlign' => DetailView::ALIGN_MIDDLE,
                    ]);
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
