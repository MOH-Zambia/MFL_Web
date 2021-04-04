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
                Data Dictionary - Validation Rules
            </p>
        </div>
    </div>


    <p style="margin-top: 30px;">
        <?php
        echo $model->name;
        ?>
    </p>
    <table>
        <tr>
            <td style="padding-right: 70px;">UID</td>
            <td><?= $model->uid ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;">Operator</td>
            <td><?= backend\models\ValidationRuleOperator::findOne($model->operator)->name ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;">Description</td>
            <td><?= !empty($model->description) ? $model->description : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;">Left Side</td>
            <td><?= !empty($model->left_side) ? $model->left_side : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;">Right Side</td>
            <td><?= !empty($model->right_side) ? $model->right_side : "" ?></td>
        </tr>
        <tr>
            <td style="padding-right: 70px;">Type</td>
            <td><?= !empty($model->type) ? $model->type : "" ?></td>
        </tr>
    </table>

</div>


