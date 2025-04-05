<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use yii\helpers\Url;

$this->title = 'ลงทะเบียนบริษัท';
?>

<div class="company-form">
    <?php $form = ActiveForm::begin([
        'id' => 'company-form',
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <?= $form->field($model, 'ref')->hiddenInput(['maxlength' => 50])->label(false); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'company_registration_number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'authorized_person')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'proxy_person')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
            <!-- หนังสือรับรองการจดทะเบียนนิติบุคคล -->

            <!-- สำเนาบัตรประชาชนผู้รับมอบอำนาจ -->
            <div class="form-group field-upload_files">
                <label class="control-label" for="upload_files[]">
                    <h4> แนบเอกสารดังต่อไปนี้ ตั้งชื่อไฟล์เป็นภาษาไทย </h4>
                </label>
                <div class="alert alert-warning" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
                        <use xlink:href="#exclamation-triangle-fill" />
                    </svg>
                    <ol>
                        <li>หนังสือรับรองการจดทะเบียนนิติบุคคล</li>
                        <li>หนังสือมอบอำนาจ</li>
                        <li>สำเนาบัตรประชาชนผู้มีอำนาจลงนาม</li>
                        <li>สำเนาบัตรประชาชนผู้รับมอบอำนาจ</li>
                    </ol>
                    <ul>
                    <li style="color:red; font-weight: bold;">พร้อมลงนามรับรองสำเนา</li>
                    </ul>

                </div>


                <div>
                    <?= FileInput::widget([
                        'name' => 'upload_ajax[]',
                        'options' => ['multiple' => true, 'accept' => 'pdf/*'], //'accept' => 'image/*' หากต้องเฉพาะ image
                        'pluginOptions' => [
                            'initialPreviewAsData' => true,  // Important for PDF preview
                            'initialPreviewFileType' => 'pdf',  // Set file type as PDF
                            'overwriteInitial' => false,
                            'encodeUrl' => false,
                            'initialPreviewShowDelete' => true,
                            'initialPreview' => $initialPreview,
                            'initialPreviewConfig' => $initialPreviewConfig,
                            'uploadUrl' => Url::to(['/company/upload-ajax']),
                            'uploadExtraData' => [
                                'ref' => $model->ref,
                            ],
                            'maxFileCount' => 100,
                            'previewFileType' => 'pdf',
                            'showPreview' => true,
                            'showCaption' => true,
                            'showRemove' => true,
                            'showUpload' => true
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-6 col-6">
            <?= Html::submitButton(
                $model->isNewRecord
                    ? '<i class="fa fa-save"></i> บันทึก'
                    : 'อัพเดทข้อมูล',
                ['class' => $model->isNewRecord ? 'btn btn-success w-100' : 'btn btn-primary w-100']
            ) ?>
        </div>
        <div class="col-md-6 col-6">
            <?= Html::resetButton(
                $model->isNewRecord
                    ? '<i class="fa fa-rotate-right"></i> เคลียร์ข้อมูล'
                    : 'คืนค่าเดิม',
                ['class' => $model->isNewRecord ? 'btn btn-danger w-100' : 'btn btn-warning w-100']
            ) ?>
        </div>
    </div>



    <?php ActiveForm::end(); ?>

    <!-- Hidden input for CSRF token to be used in AJAX requests -->
    <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken, ['id' => 'csrf-token']) ?>
</div>
<?php
$this->registerJs('
$(document).ready(function() {
    // Get the form that contains the file input
    const $form = $(".field-upload_files").closest("form");
    
    // Add a custom validation method to check file uploads
    $form.on("beforeSubmit", function(event) {
        // Get the file input plugin instance
        const $fileInput = $("[name=\"upload_ajax[]\"]");
        const fileInputInstance = $fileInput.data("krajeeFileInput");
        
        // Get the preview container to check for uploaded files
        const $previewContainer = $fileInput.closest(".file-input").find(".file-preview-thumbnails");
        const fileCount = $previewContainer.find(".file-preview-frame").length;
        const filesExist = fileCount >= 4; // Requiring at least 4 files
        
        // If no files are uploaded, prevent form submission
        if (!filesExist) {
            // Create error message if it doesn\'t exist yet
            if ($(".file-error-message").length === 0) {
                const $errorContainer = $("<div>")
                    .addClass("alert alert-danger file-error-message")
                    .css({
                        "margin-top": "10px",
                        "font-weight": "bold"
                    })
                    .text("กรุณาอัพโหลดเอกสารอย่างน้อย 4 รายการก่อนบันทึกข้อมูล");
                
                // Insert error message after the file input container
                $fileInput.closest(".file-input").after($errorContainer);
                
                // Scroll to the error message
                $("html, body").animate({
                    scrollTop: $errorContainer.offset().top - 100
                }, 500);
            }
            
            return false; // Prevent form submission
        }
        
        // If files exist, remove any error message and allow form submission
        $(".file-error-message").remove();
        return true;
    });
    
    // Add validation for when user clicks the submit button directly
    $form.find(":submit").on("click", function(event) {
        const $fileInput = $("[name=\"upload_ajax[]\"]");
        const $previewContainer = $fileInput.closest(".file-input").find(".file-preview-thumbnails");
        const fileCount = $previewContainer.find(".file-preview-frame").length;
        const filesExist = fileCount >= 4; // Requiring at least 4 files
        
        if (!filesExist) {
            event.preventDefault(); // Prevent the default submit action
            
            // Show error message
            if ($(".file-error-message").length === 0) {
                const $errorContainer = $("<div>")
                    .addClass("alert alert-danger file-error-message")
                    .css({
                        "margin-top": "10px",
                        "font-weight": "bold"
                    })
                    .text("กรุณาอัพโหลดเอกสารอย่างน้อย 4 รายการก่อนบันทึกข้อมูล");
                
                $fileInput.closest(".file-input").after($errorContainer);
                
                // Scroll to the error message
                $("html, body").animate({
                    scrollTop: $errorContainer.offset().top - 100
                }, 500);
            }
            
            return false;
        }
        
        $(".file-error-message").remove();
    });
    
    // Also validate when files are removed
    $("[name=\"upload_ajax[]\"]").on("filecleared", function(event) {
        const $previewContainer = $(this).closest(".file-input").find(".file-preview-thumbnails");
        const fileCount = $previewContainer.find(".file-preview-frame").length;
        const filesExist = fileCount >= 4; // Requiring at least 4 files
        
        if (!filesExist) {
            // Show warning that files are required
            if ($(".file-warning-message").length === 0) {
                const $warningContainer = $("<div>")
                    .addClass("alert alert-warning file-warning-message")
                    .css("margin-top", "10px")
                    .text("โปรดอัพโหลดเอกสารให้ครบทั้ง 4 รายการ");
                
                $(this).closest(".file-input").after($warningContainer);
            }
        } else {
            // Remove warning if files exist
            $(".file-warning-message").remove();
        }
    });
    
    // Remove warning when files are uploaded
    $("[name=\"upload_ajax[]\"]").on("fileloaded", function(event) {
        $(".file-warning-message").remove();
        $(".file-error-message").remove();
    });
});
');
?>