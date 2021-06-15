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
                Data Dictionary - Indicators
            </p>
        </div>
    </div>


    <p style="margin-top: 30px;">
    </p>
    <table>
         <tr>
            <td style="padding-right: 70px;font-size: 13px;">Indicator group</td>
            <td><?= backend\models\IndicatorGroup::findOne($model->indicator_group_id)->name ?></td>
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
            <td style="padding-right: 70px;font-size: 13px;">Display name</td>
            <td><?= !empty($model->name) ? $model->name : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Description</td>
            <td><?= !empty($model->description) ? $model->description : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Display short name</td>
            <td><?= !empty($model->short_name) ? $model->short_name : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Denominator description</td>
            <td><?= !empty($model->denominator_description) ? $model->denominator_description : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Numerator description</td>
            <td><?= !empty($model->numerator_description) ? $model->numerator_description : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Numerator</td>
            <td><?= !empty($model->numerator_formula) ? $model->numerator_formula : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Denominator</td>
            <td><?= !empty($model->denominator_formula) ? $model->denominator_formula : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Annualized</td>
            <td><?= !empty($model->annualized) ? $model->annualized : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Favorite</td>
            <td><?= !empty($model->favorite) ? $model->favorite : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;font-size: 13px;">Type</td>
            <td><?= !empty($model->indicator_type) ? $model->indicator_type : "%" ?></td>
        </tr>
         <tr>
            <td style="padding-right: 70px;font-size: 13px;">Frequency</td>
            <td><?= !empty($model->frequency) ? $model->frequency : "" ?></td>
        </tr>
         <tr>
            <td style="padding-right: 70px;font-size: 13px;">Level</td>
            <td><?= !empty($model->level) ? $model->level : "" ?></td>
        </tr>
         <tr>
            <td style="padding-right: 70px;font-size: 13px;">Use and Context</td>
            <td><?= !empty($model->use_and_context) ? $model->use_and_context : "" ?></td>
        </tr>
    </table>

</div>


