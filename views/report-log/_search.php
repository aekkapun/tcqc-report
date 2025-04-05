<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MacTestVehCertDetailReportSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mac-test-veh-cert-detail-report-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'OFF_CODE') ?>

    <?= $form->field($model, 'BR_CODE') ?>

    <?= $form->field($model, 'CAR_TEST_TYPE') ?>

    <?= $form->field($model, 'CERT_YEAR') ?>

    <?php // echo $form->field($model, 'CERT_NO') ?>

    <?php // echo $form->field($model, 'CAR_TYPE') ?>

    <?php // echo $form->field($model, 'PLATE1') ?>

    <?php // echo $form->field($model, 'PLATE2') ?>

    <?php // echo $form->field($model, 'NUM_BODY') ?>

    <?php // echo $form->field($model, 'ENG_FLAG') ?>

    <?php // echo $form->field($model, 'NUM_ENG') ?>

    <?php // echo $form->field($model, 'SERIES_NAME') ?>

    <?php // echo $form->field($model, 'TEST_DATE') ?>

    <?php // echo $form->field($model, 'TEST_DISTANCE') ?>

    <?php // echo $form->field($model, 'TEST_TIME') ?>

    <?php // echo $form->field($model, 'IS_REPORT') ?>

    <?php // echo $form->field($model, 'REPORT_DATE') ?>

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
