<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\VehTestReportSchedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="veh-test-report-schedule-form">
    <?php $form = ActiveForm::begin(); ?>
    
    <div class="row">
        <!-- คอลัมน์ซ้าย: ข้อมูลของ VehTestReportSchedule -->
        <div class="col-md-6">
            <?= $form->field($model, 'report_date')->textInput()->label('รอบวันที่') ?>
            <?= $form->field($model, 'report_month')->hiddenInput(['maxlength' => true])->label(false) ?>
            <?= $form->field($model, 'report_status')->dropDownList([
                'pending' => 'Pending', 
                'reported' => 'Reported', 
                'late' => 'Late', 
                'missed' => 'Missed', 
            ], ['prompt' => '']) ?>
            <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>
        </div>

        <!-- คอลัมน์ขวา: ข้อมูลของ VehTestReportDetail -->
        <div class="col-md-6">
            <?php
            echo $form->field($detailModel, 'test_date_from')->widget(DatePicker::classname(), [
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
                        <?php
            echo $form->field($detailModel, 'test_date_to')->widget(DatePicker::classname(), [
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
            <?= $form->field($detailModel, 'test_distance')->textInput(['maxlength' => true]) ?>
            <?= $form->field($detailModel, 'test_time')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group text-center">
            <?= Html::submitButton(
                $model->isNewRecord ? 'Create' : 'Update', 
                ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
            ) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
</div>

