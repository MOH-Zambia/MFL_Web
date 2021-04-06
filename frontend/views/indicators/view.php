<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Indicators */

$this->title = $model->uid;
$this->params['breadcrumbs'][] = ['label' => 'Indicators', 'url' => ['index']];
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
                                ['/indicators/download', 'id' => $model->id], [
                            'title' => 'Download indicator',
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
                                    'attribute' => 'indicator_group_id',
                                    'format' => 'raw',
                                    'value' => !empty($model->indicator_group_id) ? backend\models\IndicatorGroup::findOne($model->indicator_group_id)->name : "",
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => "uid",
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => "name",
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => "short_name",
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => "code",
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => "definition",
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => "numerator_description",
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => "numerator_formula",
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => "denominator_description",
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => "denominator_formula",
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => "indicator_type",
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => "annualized",
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => "level",
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => "favorite",
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'use_and_context',
                                    'label' => "Use and Context",
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'attribute' => "frequency",
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'value' => $model->frequency
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                //'nids_versions',
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
                        'attributes' => $attributes,
                    ]);
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
