<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;

/** @var yii\web\View $this */
/** @var app\models\Registser $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="registser-form">
        <?php $form = ActiveForm::begin(); ?>
<div class="card">
  <div class="card-header">
    ลงทะเบียน
  </div>
  <div class="card-body">
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'dbd_no')->textInput(['maxlength' => true])->label('เลขนิติบุคคล') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'dbd_name')->textInput(['maxlength' => true])->label('ชื่อบริษัท') ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'dbd_manager')->textInput(['maxlength' => true])->label('ชื่อ-สกุล ผู้มีดำนาจลงนาม') ?>
        </div>
    </div>

   <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'user_docno')->textInput(['maxlength' => true])->label('เลข บัตรประชาชน') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('คำนำหน้าชื่อ') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'fname')->textInput(['maxlength' => true])->label('ชื่อ ') ?>
        </div>
          <div class="col-md-3">
            <?= $form->field($model, 'lname')->textInput(['maxlength' => true])->label('สกุล ') ?>
        </div>
    </div>

   <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('email') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'tel')->textInput(['maxlength' => true])->label('เบอร์โทร') ?>
        </div>
    </div>

        <div class="form-group field-upload_files">
        <label class="control-label" for="upload_files[]"> ภาพถ่าย สถานตรวจสภาพรถ </label>
        <?= $form->field($model, 'ref')->hiddenInput()->label(false); ?>
        <div>
             <?= FileInput::widget([
            'name' => 'upload_ajax[]',
            'options' => [
                'multiple' => true,
                'accept' => 'image/*'
            ],
            'pluginOptions' => [
                'overwriteInitial' => false,
                'encodeUrl'=>false,
                'initialPreview' => $initialPreview,
                'initialPreviewConfig' => $initialPreviewConfig,
                'uploadUrl' => \yii\helpers\Url::to(['/register/upload-ajax']),
                'uploadExtraData' => [
                    'ref' => $model->ref,
                    '_csrf' => Yii::$app->request->getCsrfToken()
                ],
                'maxFileCount' => 100,
                'maxFileSize' => 5120, // 5MB
                'showPreview' => true,
                'showCaption' => true,
                'showRemove' => true,
                'showUpload' => true,
                'initialPreviewAsData' => true,
                'msgFilesTooMany' => 'จำนวนไฟล์ที่อัพโหลด ({n}) เกินกว่าที่กำหนด ({m})',
                'msgSizeTooLarge' => 'ไฟล์ "{name}" ({size} KB) มีขนาดเกินกว่าที่กำหนด ({maxSize} KB)',
                'msgInvalidFileType' => 'ไฟล์ "{name}" เป็นประเภทไฟล์ที่ไม่รองรับ กรุณาอัพโหลดเฉพาะไฟล์รูปภาพ',
            ]
        ]); ?>
        </div>
    </div>

    <div class="row">
    <div class="col-md-12">
        
                        <div class="row block ">

                    <div class="col-md-6 col-xs-6">
                        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก' : 'อัพเดทข้อมูล', ['class' => ($model->isNewRecord ? 'btn btn-success' : 'btn btn-primary') . '   btn-block',
//                            'data' => [
//                                'confirm' => 'ยืนยันการบันทึกข้อมูล',
//                                'method' => 'post',
//                            ],
                        ]) ?>
                    </div>
                    <div class="col-md-6 col-xs-6">
                        <?= Html::resetButton($model->isNewRecord ? '<i class="glyphicon glyphicon-refresh"></i> ยกเลิก' : 'คืนค่าเดิม', ['id'=>'btnSubmit','class' => ($model->isNewRecord ? 'btn btn-danger' : 'btn btn-warning') . '   btn-block']) ?>
                    </div>
                </div>
    </div>
</div>
</div>

    <?php ActiveForm::end(); ?>

</div>
