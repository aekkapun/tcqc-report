<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VehTestReportSchedule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="veh-test-report-schedule-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'OFF_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BR_CODE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CAR_TEST_TYPE')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CERT_YEAR')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'CERT_NO')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PLATE1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PLATE2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'PLATE_SEQ')->textInput() ?>

    <?= $form->field($model, 'report_date')->textInput() ?>

    <?= $form->field($model, 'report_month')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'report_status')->dropDownList([ 'pending' => 'Pending', 'reported' => 'Reported', 'late' => 'Late', 'missed' => 'Missed', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'actual_report_date')->textInput() ?>

    <?= $form->field($model, 'is_fined')->textInput() ?>

    <?= $form->field($model, 'fine_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fine_payment_status')->dropDownList([ 'unpaid' => 'Unpaid', 'paid' => 'Paid', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'fine_payment_date')->textInput() ?>

    <?= $form->field($model, 'fine_receipt_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

  
    <?php if (!Yii::$app->request->isAjax){ ?>
          <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>