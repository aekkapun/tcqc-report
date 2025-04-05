<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VehTestReportDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="veh-test-report-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'schedule_id')->textInput() ?>

    <?= $form->field($model, 'test_date_from')->textInput() ?>

    <?= $form->field($model, 'test_date_to')->textInput() ?>

    <?= $form->field($model, 'test_distance')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'test_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'test_location')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'test_purpose')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'test_result')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'report_file')->textInput(['maxlength' => true]) ?>

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
