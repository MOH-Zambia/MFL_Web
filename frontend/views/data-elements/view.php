<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\DataElements */

$this->title = $model->uid;
$this->params['breadcrumbs'][] = ['label' => 'Data elements', 'url' => ['index']];
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
                                ['/data-elements/download', 'id' => $model->id], [
                            'title' => 'Download data element',
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
                                    'attribute' => 'short_name',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'code',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'label' => 'DataElementGroup',
                                    'attribute' => 'element_group_id',
                                    'format' => 'raw',
                                    'value' => !empty($model->element_group_id) ? backend\models\DataElementGroup::findOne($model->element_group_id)->name : ""
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'definition',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'aggregation_type',
                                    'label' => 'AggregationType',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'domain_type',
                                    'label' => 'DomainType',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'description',
                                    'label' => 'Description',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'definition_extended',
                                    'label' => 'DefinitionType',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'use_and_context',
                                    'label' => 'UseAndContext',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'inclusions',
                                    //  'label' => 'UseAndContext',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'exclusions',
                                    //  'label' => 'UseAndContext',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'collected_by',
                                    'label' => 'CollectedBy',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'collection_point',
                                    'label' => 'CollectionPoint',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'keep_zero_values',
                                    'label' => 'KeepZeroValues',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'zeroissignificant',
                                    'label' => 'ZeroIsSignificant',
                                    'displayOnly' => true,
                                ],
                            ],
                        ],
                        [
                            'columns' => [
                                [
                                    'valueColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:30%'],
                                    'labelColOptions' => ['style' => 'font-size:13px;font-weight:normal;width:15%'],
                                    'attribute' => 'favorite',
                                    'label' => 'Favorite',
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
