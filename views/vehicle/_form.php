<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MacTestVehCertDetail $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mac-test-veh-cert-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'OFF_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BR_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAR_TEST_TYPE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CERT_YEAR')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CERT_NO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAR_TYPE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PLATE1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PLATE2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PLATE_SEQ')->textInput() ?>

    <?= $form->field($model, 'NUM_BODY')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ENG_FLAG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NUM_ENG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SERIES_NAME')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TEST_DATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TEST_DISTANCE')->textInput() ?>

    <?= $form->field($model, 'TEST_TIME')->textInput() ?>

    <?= $form->field($model, 'RENEW_DATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LAST_CPY_NO')->textInput() ?>

    <?= $form->field($model, 'LAST_CPY_DATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SEND_BACK_DATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STOP_USE_DATE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'SEND_BACK_FLAG')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'VEH_STATUS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'UPD_USER_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'LAST_UPD_DATE')->textInput() ?>

    <?= $form->field($model, 'CREATE_USER_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CREATE_DATE')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
