<?php

use kartik\ipinfo\IpInfo;
use backend\models\User;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\popover\PopoverX;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AuditTrailHeaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Audit logs';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="card card-primary card-outline">
    <div class="card-body">
        <?php
        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user',
                'label' => 'User',
                'format' => 'raw',
                'options' => ["width" => "270px"],
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filter' => User::getActiveUsers(),
                'filterInputOptions' => ['prompt' => 'Filter by user', 'class' => 'form-control', 'id' => null],
                "value" => function ($model) {
                    $name = "";
                    $user_model = User::findOne(["id" => $model->user]);
                    if (!empty($user_model)) {
                        $name = $user_model->first_name . " " .$user_model->last_name;
                    }
                    return $name;
                }
            ],
            [
                'attribute' => 'action',
                'format' => 'raw',
                'filter' => false
            ],
            [
                'attribute' => 'date',
                'options' => ["width" => "230px"],
                'value' => function($model) {
                    return date('d-M-Y H:i:s', $model->date);
                },
                'label' => 'Date',
                'filterType' => GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => (
                [
                    // 'presetDropdown' => true,
                    'convertFormat' => false,
                    'pluginOptions' => [
                        'separator' => ' - ',
                        'allowClear' => true,
                        'format' => 'YYYY/MM/DD',
                        'locale' => [
                            'format' => 'YYYY/MM/DD'
                        ],
                    ],
                ]
                ),
                'filterInputOptions' => ['prompt' => 'Filter by Date', 'class' => 'form-control', 'id' => null],
            ],
            [
                'attribute' => 'ip_address',
                'options' => ["width" => "230px"],
                'format' => 'raw',
                'value' => function($model) {
                    return IpInfo::widget([
                                'ip' => $model->ip_address,
                                'cache' => true,
                                'template' => ['popoverButton' => '{flag} ({city} - {country})'],
                                'skipFields' => ['city', 'region', 'zip'],
                                'popoverOptions' => [
                                    'toggleButton' => ['class' => 'btn btn-secondary btn-md'],
                                    'placement' => PopoverX::ALIGN_BOTTOM_RIGHT,
                                    'type'=>'success'
                                ]
                    ]);
                }
            ],
            [
                'label' => 'User agent',
                'attribute' => 'user_agent',
                'filter' => false
            ],
        ];
        $gridColumns2 = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user',
                'label' => 'User',
                'format' => 'raw',
                "value" => function ($model) {
                    $name = "";
                    $user_model = User::findOne(["id" => $model->user]);
                    if (!empty($user_model)) {
                        $name = $user_model->first_name . " " . $user_model->other_name . " " . $user_model->last_name . "-" . $user_model->email;
                    }
                    return $name;
                }
            ],
            [
                'attribute' => 'action',
            ],
            [
                'label' => 'Date',
                'value' => function($model) {
                    return date('d-M-Y H:i:s', $model->date);
                }
            ],
            [
                'label' => 'IP address',
                'attribute' => 'ip_address',
            ],
            [
                'label' => 'User agent',
                'attribute' => 'user_agent',
            ],
        ];
        ?>

        <?=
        ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns2,
            'fontAwesome' => true,
            'dropdownOptions' => [
                'label' => 'Export All',
                'class' => 'btn btn-default'
            ],
            'filename' => 'audittraillogs' . date("YmdHis")
        ])
        ?>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
           // 'pjax' => true,
            'columns' => $gridColumns,
            'export' => [
            'fontAwesome' => true,
            ]
        ]);
        ?>
        

    </div>
</div>
<?php
$this->registerCss('.popover-x {display:none}');
?>
