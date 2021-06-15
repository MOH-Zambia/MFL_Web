<?php

use yii\helpers\Html;
?>

<div class="container ">
    <div class="row">
        <div class="text-left" >
            <?= Html::img('@web/img/coa.png', ['style' => 'width:100px; height: 100px']); ?>
        </div>
        <div class="text-center" style="margin-top: 20px;margin-bottom: 60px;margin-top: -100px;font-weight: normal;font-size: 20px;">
            <p>
                Data Dictionary - Data Elements
            </p>
        </div>
    </div>


    <p style="margin-top: 30px;">
    </p>
    <table>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Data element group</td>
            <td><?= backend\models\DataElementGroup::findOne($model->element_group_id)->name ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Code</td>
            <td><?= $model->code ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Last updated</td>
            <td><?= date('Y-m-d h:i:s', $model->updated_at) ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">UID</td>
            <td><?= $model->uid ?></td>
        </tr>

        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Name</td>
            <td><?= !empty($model->name) ? $model->name : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Short name</td>
            <td><?= !empty($model->short_name) ? $model->short_name : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Aggregation type</td>
            <td><?= !empty($model->aggregation_type) ? $model->aggregation_type : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Domain type</td>
            <td><?= !empty($model->domain_type) ? $model->domain_type : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Description</td>
            <td><?= !empty($model->definition) ? $model->definition : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Display short name</td>
            <td><?= !empty($model->short_name) ? $model->short_name : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Display form name</td>
            <td><?= !empty($model->name) ? $model->name : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Zero is significant</td>
            <td><?= !empty($model->zeroissignificant) ? $model->zeroissignificant : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Favorite</td>
            <td><?= !empty($model->favorite) ? $model->favorite : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Numerator description</td>
            <td><?= !empty($model->numerator_description) ? $model->numerator_description : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Keep zero values</td>
            <td><?= !empty($model->keep_zero_values) ? $model->keep_zero_values : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Collection Tool</td>
            <td><?= !empty($model->tools) ? $model->tools : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Comment</td>
            <td><?= !empty($model->description) ? $model->description : "" ?></td>
        </tr>

        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Data element inclusions</td>
            <td><?= !empty($model->inclusions) ? $model->inclusions : "%" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Data element exclusions</td>
            <td><?= !empty($model->exclusions) ? $model->exclusions : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Collected by</td>
            <td><?= !empty($model->collected_by) ? $model->collected_by : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Collection points</td>
            <td><?= !empty($model->collection_point) ? $model->collection_point : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">DataElementDescriptionExtended</td>
            <td><?= !empty($model->definition_extended) ? $model->definition_extended : "" ?></td>
        </tr>
    </table>

</div>


