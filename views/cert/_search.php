<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MacTestVehCertSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mac-test-veh-cert-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'OFF_CODE') ?>

    <?= $form->field($model, 'BR_CODE') ?>

    <?= $form->field($model, 'CAR_TEST_TYPE') ?>

    <?= $form->field($model, 'CERT_YEAR') ?>

    <?= $form->field($model, 'CERT_NO') ?>

    <?php // echo $form->field($model, 'TEST_VEH_CODE') ?>

    <?php // echo $form->field($model, 'TITLE_CODE') ?>

    <?php // echo $form->field($model, 'ID_NO') ?>

    <?php // echo $form->field($model, 'FNAME') ?>

    <?php // echo $form->field($model, 'LNAME') ?>

    <?php // echo $form->field($model, 'ADDR') ?>

    <?php // echo $form->field($model, 'DIST_CODE') ?>

    <?php // echo $form->field($model, 'AMP_CODE') ?>

    <?php // echo $form->field($model, 'PRV_CODE') ?>

    <?php // echo $form->field($model, 'PHONE') ?>

    <?php // echo $form->field($model, 'NUM_CAR') ?>

    <?php // echo $form->field($model, 'NUM_PLATE') ?>

    <?php // echo $form->field($model, 'INS_CODE') ?>

    <?php // echo $form->field($model, 'INS_NO') ?>

    <?php // echo $form->field($model, 'INS_EXP_DATE') ?>

    <?php // echo $form->field($model, 'FST_PMT_DATE') ?>

    <?php // echo $form->field($model, 'PMT_DATE') ?>

    <?php // echo $form->field($model, 'EXP_DATE') ?>

    <?php // echo $form->field($model, 'CERT_STATUS') ?>

    <?php // echo $form->field($model, 'RENEW_DATE') ?>

    <?php // echo $form->field($model, 'LAST_CPY_NO') ?>

    <?php // echo $form->field($model, 'LAST_CPY_DATE') ?>

    <?php // echo $form->field($model, 'STOP_USE_DATE') ?>

    <?php // echo $form->field($model, 'SEND_BACK_DATE') ?>

    <?php // echo $form->field($model, 'FNC_DATE') ?>

    <?php // echo $form->field($model, 'RCP_NO1') ?>

    <?php // echo $form->field($model, 'RCP_NO2') ?>

    <?php // echo $form->field($model, 'PRV_OFF_CODE') ?>

    <?php // echo $form->field($model, 'PRV_BR_CODE') ?>

    <?php // echo $form->field($model, 'PRV_CAR_TEST_TYPE') ?>

    <?php // echo $form->field($model, 'PRV_CERT_YEAR') ?>

    <?php // echo $form->field($model, 'PRV_CERT_NO') ?>

    <?php // echo $form->field($model, 'UPD_USER_CODE') ?>

    <?php // echo $form->field($model, 'LAST_UPD_DATE') ?>

    <?php // echo $form->field($model, 'CREATE_USER_CODE') ?>

    <?php // echo $form->field($model, 'CREATE_DATE') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
