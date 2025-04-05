<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\MacTestVehCertDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mac-test-veh-cert-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'OFF_CODE')->hiddenInput(['maxlength' => true])->label(false) ?>
    <?= $form->field($model, 'BR_CODE')->hiddenInput(['maxlength' => true])->label(false) ?>
    <?= $form->field($model, 'CAR_TEST_TYPE')->hiddenInput(['maxlength' => true])->label(false) ?>
    <?= $form->field($model, 'CERT_YEAR')->hiddenInput(['maxlength' => true])->label(false) ?>
    <?= $form->field($model, 'CERT_NO')->hiddenInput(['maxlength' => true])->label(false) ?>
    <?= $form->field($model, 'CAR_TYPE')->hiddenInput(['maxlength' => true])->label(false) ?>
    <div class="row panel-default">
        <div class="col-md-2">
            <?= $form->field($model, 'PLATE1')->textInput(['maxlength' => true, 'readonly' => true])->label('ทะเบียน') ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'PLATE2')->textInput(['maxlength' => true, 'readonly' => true])->label('.') ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'NUM_BODY')->textInput(['maxlength' => true, 'readonly' => true])->label('หมายเลขตัวรถ') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'NUM_ENG')->textInput(['maxlength' => true, 'readonly' => true])->label('หมายเลขเครื่องยนต์') ?>
        </div>
        <div class="col-md-4">
            <?php
            echo $form->field($model, 'TEST_DATE')->widget(DatePicker::classname(), [
                'language' => 'th',
                'options' => [
                    'placeholder' => 'ระบุวันที่ ...',
                    //'required' => true, // บังคับให้กรอก
                ],
                'pickerIcon' => '<i class="fas fa-calendar-alt text-primary"></i>',
                'removeIcon' => '<i class="fas fa-trash text-danger"></i>',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'todayBtn' => true,
                    'language' => 'th', // กำหนดให้แสดงภาษาไทย
                ]
            ]);

            ?>
        </div>
    </div>
    <div class="row">

        <div class="col-md-4">
            <?= $form->field($model, 'TEST_DISTANCE')->textInput(['maxlength' => true, 'readonly' => false]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'TEST_TIME')->textInput(['maxlength' => true, 'readonly' => false]) ?>

        </div>
        <div class="col-md-4">
            <?php
            echo $form->field($model, 'STOP_USE_DATE')->widget(DatePicker::classname(), [
                'language' => 'th',
                'options' => [
                    'placeholder' => 'ระบุวันที่ ...',
                    // 'required' => true, // บังคับให้กรอก
                ],
                'pickerIcon' => '<i class="fas fa-calendar-alt text-primary"></i>',
                'removeIcon' => '<i class="fas fa-trash text-danger"></i>',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true,
                    'todayBtn' => true,
                    'language' => 'th', // กำหนดให้แสดงภาษาไทย
                ]
            ]);

            ?>

        </div>
    </div>


    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>