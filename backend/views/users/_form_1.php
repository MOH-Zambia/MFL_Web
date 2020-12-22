<?php

use yii\helpers\Html;
//use yii\bootstrap4\ActiveForm;
use common\models\Role;
use borales\extensions\phoneInput\PhoneInput;
use kartik\form\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
$model->user_type = $user_type;
?>



<?php
$form = ActiveForm::begin(['action' => 'update?id=' . $model->id, 'type' => ActiveForm::TYPE_VERTICAL, 'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]]);
?>

<div class="row" style="">
    <div class="col-lg-4">
        <?=
        $form->field($model, 'user_type', [
                /* 'addon' => [
                  'append' => [
                  'content' => Html::submitButton('Update', ['name' => 'addUser', 'value' => 'true', 'class' => 'btn btn-success btn-sm']),
                  'asButton' => true
                  ]
                  ] */
        ])->dropDownList(
                [
            'Camp user' => 'Camp user',
            'District user' => 'District user',
            'Provincial user' => 'Provincial user',
            'Other user' => 'Other user',
                ], [
            'custom' => true,
            'prompt' => 'Filter system user type to add',
            'required' => true,
                ]
        )->label("User type");
        ?>
    </div>
    <div class="col-lg-2">
        &nbsp;
    </div>
    <div class="col-lg-6">
        <h4>Instructions</h4>
        <ol>
            <li>Update only the fields that needs to be updated.
                The system will make the necessary update to the other fields.</li>
            <li>Email is used as login username, changing it changes the username</li>

        </ol>
    </div>
</div>


<?php
echo $form->field($model, 'type_of_user')->hiddenInput(['value' => $user_type])->label(false);
?>
<hr class="dotted short">
<div class="row">
    <?php
//For other user types
    if ($user_type === "Other user") {
        echo '<div class="col-md-6">';

        echo $form->field($model, 'first_name')->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'First name'])->label("First name");
        echo $form->field($model, 'last_name')->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Last name'])->label("Last name");
        echo $form->field($model, 'other_name')->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Other names']);

        echo $form->field($model, 'title')->dropDownList(
                [
            'Mr.' => 'Mr',
            'Mrs.' => 'Mrs',
            'Miss.' => 'Miss',
            'Ms.' => 'Ms',
            'Dr.' => 'Dr',
            'Prof.' => 'Prof'
                ], ['prompt' => 'Select title', 'custom' => true, 'required' => false]
        );

        echo "<label class='label' for='sex'>Sex</label>";
        echo $form->field($model, 'sex')->radioButtonGroup([
            'Male' => 'Male',
            'Female' => 'Female',
                ], [
            'maxlength' => true,
            'id' => "sex",
            'class' => 'btn-group-sm',
                //'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary btn-sm']]
        ])->label(false);
        echo '</div>
    <div class="col-md-6">';
        echo $form->field($model, 'nrc', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'placeholder' => 'NRC i.e. 100000/10/1']);


        echo "<label class='label' for='phone'>Phone</label>";
        echo $form->field($model, 'phone')->widget(PhoneInput::className(), [
            'jsOptions' => [
                'allowExtensions' => true,
                'preferredCountries' => ['ZM'],
            ]
                ], ['maxlength' => true, 'id' => "phone"])->label(false);
        echo $form->field($model, 'email', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'type' => 'email', 'placeholder' => 'email address', 'required' => true])->label("Email");

        echo $form->field($model, 'role')->dropDownList(
                yii\helpers\ArrayHelper::map(Role::find()->asArray()->all(), 'id', 'role'), ['custom' => true, 'maxlength' => true, 'style' => '', 'prompt' => 'Please select role', 'required' => true]
        )->label("Role");
        echo '</div>';
    }
//For Camp user types
    if ($user_type === "Camp user") {
        echo '<div class="col-md-6">';

        echo $form->field($model, 'first_name')->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'First name'])->label("First name");
        echo $form->field($model, 'last_name')->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Last name'])->label("Last name");
        echo $form->field($model, 'other_name')->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Other names']);

        echo $form->field($model, 'title')->dropDownList(
                [
            'Mr.' => 'Mr',
            'Mrs.' => 'Mrs',
            'Miss.' => 'Miss',
            'Ms.' => 'Ms',
            'Dr.' => 'Dr',
            'Prof.' => 'Prof'
                ], ['prompt' => 'Select title', 'custom' => true, 'required' => false]
        );

        echo "<label class='label' for='sex'>Sex</label>";
        echo $form->field($model, 'sex')->radioButtonGroup([
            'Male' => 'Male',
            'Female' => 'Female',
                ], [
            'maxlength' => true,
            'id' => "sex",
            'class' => 'btn-group-sm',
                //'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary btn-sm']]
        ])->label(false);
        echo $form->field($model, 'nrc', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'placeholder' => 'NRC i.e. 100000/10/1']);

        echo '</div>
    <div class="col-md-6">';

        echo "<label class='label' for='phone'>Phone</label>";
        echo $form->field($model, 'phone')->widget(PhoneInput::className(), [
            'jsOptions' => [
                'allowExtensions' => true,
                'preferredCountries' => ['ZM'],
            ]
                ], ['maxlength' => true, 'id' => "phone"])->label(false);
        echo $form->field($model, 'email', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'type' => 'email', 'placeholder' => 'email address', 'required' => true])->label("Email");

        echo $form->field($model, 'role')->dropDownList(
                yii\helpers\ArrayHelper::map(Role::find()->asArray()->all(), 'id', 'role'), ['custom' => true, 'maxlength' => true, 'style' => '', 'prompt' => 'Please select role', 'required' => true]
        )->label("Role");

        echo
                $form->field($model, 'province_id')
                ->dropDownList(
                        \backend\models\Provinces::getProvinceList(), ['id' => 'prov_id', 'custom' => true, 'prompt' => 'Please select a province', 'required' => true]
        );

        echo Html::hiddenInput('selected_id', $model->isNewRecord ? '' : $model->district_id, ['id' => 'selected_id']);

        echo $form->field($model, 'district_id')->widget(DepDrop::classname(), [
            'options' => ['id' => 'dist_id', 'custom' => true, 'required' => TRUE],
            'pluginOptions' => [
                'depends' => ['prov_id'],
                'initialize' => $model->isNewRecord ? false : true,
                'placeholder' => 'Please Select a district',
                'url' => Url::to(['/camps/district']),
                'params' => ['selected_id'],
            ]
        ]);

        echo Html::hiddenInput('selected_id3', $model->isNewRecord ? '' : $model->camp_id, ['id' => 'selected_id3']);
        echo $form->field($model, 'camp_id')->widget(DepDrop::classname(), [
            'options' => ['id' => 'name', 'custom' => true, 'required' => TRUE],
            'pluginOptions' => [
                'depends' => ['dist_id'],
                'initialize' => $model->isNewRecord ? false : true,
                'placeholder' => 'Please Select a camp',
                'url' => Url::to(['/camps/camp']),
                'params' => ['selected_id3'],
            ]
        ]);

        echo '</div>';
    }


//For District user types
    if ($user_type === "District user") {
        echo '<div class="col-md-6">';

        echo $form->field($model, 'first_name')->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'First name'])->label("First name");
        echo $form->field($model, 'last_name')->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Last name'])->label("Last name");
        echo $form->field($model, 'other_name')->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Other names']);

        echo $form->field($model, 'title')->dropDownList(
                [
            'Mr.' => 'Mr',
            'Mrs.' => 'Mrs',
            'Miss.' => 'Miss',
            'Ms.' => 'Ms',
            'Dr.' => 'Dr',
            'Prof.' => 'Prof'
                ], ['prompt' => 'Select title', 'custom' => true, 'required' => false]
        );
        echo $form->field($model, 'nrc', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'placeholder' => 'NRC i.e. 100000/10/1']);

        echo "<label class='label' for='sex'>Sex</label>";
        echo $form->field($model, 'sex')->radioButtonGroup([
            'Male' => 'Male',
            'Female' => 'Female',
                ], [
            'maxlength' => true,
            'id' => "sex",
            'class' => 'btn-group-sm',
                //'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary btn-sm']]
        ])->label(false);

        echo '</div>
    <div class="col-md-6">';

        echo "<label class='label' for='phone'>Phone</label>";
        echo $form->field($model, 'phone')->widget(PhoneInput::className(), [
            'jsOptions' => [
                'allowExtensions' => true,
                'preferredCountries' => ['ZM'],
            ]
                ], ['maxlength' => true, 'id' => "phone"])->label(false);
        echo $form->field($model, 'email', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'type' => 'email', 'placeholder' => 'email address', 'required' => true])->label("Email");

        echo $form->field($model, 'role')->dropDownList(
                yii\helpers\ArrayHelper::map(Role::find()->asArray()->all(), 'id', 'role'), ['custom' => true, 'maxlength' => true, 'style' => '', 'prompt' => 'Please select role', 'required' => true]
        )->label("Role");

        echo
                $form->field($model, 'province_id')
                ->dropDownList(
                        \backend\models\Provinces::getProvinceList(), ['id' => 'prov_id', 'custom' => true, 'prompt' => 'Please select a province', 'required' => true]
        );

        echo Html::hiddenInput('selected_id', $model->isNewRecord ? '' : $model->district_id, ['id' => 'selected_id']);

        echo $form->field($model, 'district_id')->widget(DepDrop::classname(), [
            'options' => ['id' => 'dist_id', 'custom' => true, 'required' => TRUE],
            'pluginOptions' => [
                'depends' => ['prov_id'],
                'initialize' => $model->isNewRecord ? false : true,
                'placeholder' => 'Please Select a district',
                'url' => Url::to(['/camps/district']),
                'params' => ['selected_id'],
            ]
        ]);


        echo '</div>';
    }
//For Provincial user types
    if ($user_type === "Provincial user") {
        echo '<div class="col-md-6">';

        echo $form->field($model, 'first_name')->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'First name'])->label("First name");
        echo $form->field($model, 'last_name')->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Last name'])->label("Last name");
        echo $form->field($model, 'other_name')->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Other names']);

        echo $form->field($model, 'title')->dropDownList(
                [
            'Mr.' => 'Mr',
            'Mrs.' => 'Mrs',
            'Miss.' => 'Miss',
            'Ms.' => 'Ms',
            'Dr.' => 'Dr',
            'Prof.' => 'Prof'
                ], ['prompt' => 'Select title', 'custom' => true, 'required' => false]
        );

        echo "<label class='label' for='sex'>Sex</label>";
        echo $form->field($model, 'sex')->radioButtonGroup([
            'Male' => 'Male',
            'Female' => 'Female',
                ], [
            'maxlength' => true,
            'id' => "sex",
            'class' => 'btn-group-sm',
                //'itemOptions' => ['labelOptions' => ['class' => 'btn btn-primary btn-sm']]
        ])->label(false);

        echo '</div>
    <div class="col-md-6">';
        echo $form->field($model, 'nrc', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'placeholder' => 'NRC i.e. 100000/10/1']);

        echo "<label class='label' for='phone'>Phone</label>";
        echo $form->field($model, 'phone')->widget(PhoneInput::className(), [
            'jsOptions' => [
                'allowExtensions' => true,
                'preferredCountries' => ['ZM'],
            ]
                ], ['maxlength' => true, 'id' => "phone"])->label(false);
        echo $form->field($model, 'email', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'type' => 'email', 'placeholder' => 'email address', 'required' => true])->label("Email");

        echo $form->field($model, 'role')->dropDownList(
                yii\helpers\ArrayHelper::map(Role::find()->asArray()->all(), 'id', 'role'), ['custom' => true, 'maxlength' => true, 'style' => '', 'prompt' => 'Please select role', 'required' => true]
        )->label("Role");

        echo
                $form->field($model, 'province_id')
                ->dropDownList(
                        \backend\models\Provinces::getProvinceList(), ['id' => 'prov_id', 'custom' => true, 'prompt' => 'Please select a province', 'required' => true]
        );
        echo '</div>';
    }
    ?>
    <div class="form-group col-lg-12">
        <?= Html::submitButton('Update', ['class' => 'btn btn-success btn-sm']); ?>
    </div>

</div>
<?php ActiveForm::end(); ?>


