<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MacTestVehCert $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mac-test-veh-cert-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'OFF_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BR_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAR_TEST_TYPE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CERT_YEAR')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CERT_NO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TEST_VEH_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TITLE_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ID_NO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FNAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LNAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ADDR')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'DIST_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'AMP_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PRV_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PHONE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NUM_CAR')->textInput() ?>

    <?= $form->field($model, 'NUM_PLATE')->textInput() ?>

    <?= $form->field($model, 'INS_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'INS_NO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'INS_EXP_DATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FST_PMT_DATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PMT_DATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'EXP_DATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CERT_STATUS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'RENEW_DATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LAST_CPY_NO')->textInput() ?>

    <?= $form->field($model, 'LAST_CPY_DATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STOP_USE_DATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SEND_BACK_DATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'FNC_DATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'RCP_NO1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'RCP_NO2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PRV_OFF_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PRV_BR_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PRV_CAR_TEST_TYPE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PRV_CERT_YEAR')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PRV_CERT_NO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPD_USER_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LAST_UPD_DATE')->textInput() ?>

    <?= $form->field($model, 'CREATE_USER_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATE_DATE')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
