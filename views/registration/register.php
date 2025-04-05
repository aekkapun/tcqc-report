<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Company */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'ลงทะเบียนเพื่อขอ User name และ Password';
$this->params['breadcrumbs'][] = $this->title;

// เพิ่ม CSS เพื่อปรับปรุง UI
$this->registerCss("
    .panel {
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        margin-bottom: 25px;
    }
    .panel-heading {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }
    .panel-title {
        font-weight: 600;
        color: #495057;
    }
    .form-control {
        height: 45px;
        border-radius: 5px;
    }
    .btn-success {
        padding: 10px 30px;
        font-size: 16px;
        border-radius: 5px;
        background-color: #28a745;
        border-color: #28a745;
        font-weight: 500;
        transition: all 0.3s;
    }
    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .btn-primary {
        border-radius: 5px;
    }
    .file-preview {
        border-radius: 5px;
        border: 1px solid #ddd;
    }
    .alert-info {
        border-left: 5px solid #17a2b8;
        background-color: #e8f4f8;
        border-radius: 5px;
    }
    .help-block {
        margin-top: 8px;
        color: #6c757d;
    }
    .text-success {
        color: #28a745 !important;
    }
    .text-danger {
        color: #dc3545 !important;
    }
    .upload-status {
        margin-top: 10px;
        padding: 8px;
        border-radius: 5px;
        background-color: #f8f9fa;
    }
    .file-drop-zone {
        border: 2px dashed #ccc;
        border-radius: 5px;
        transition: all 0.3s;
    }
    .file-drop-zone.highlighted {
        border-color: #28a745;
        background-color: #f8fff8;
    }
    #registration-form {
        max-width: 1200px;
        margin: 0 auto;
    }
    .kv-upload-progress .progress {
        height: 15px;
        border-radius: 10px;
        margin-bottom: 10px;
        box-shadow: none;
    }
    .kv-upload-progress .progress-bar {
        line-height: 15px;
    }
");
?>
<div class="company-registration">

    <h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-info">
        <strong><i class="glyphicon glyphicon-info-sign"></i> หมายเหตุ:</strong> กรุณากรอกข้อมูลให้ครบถ้วนและแนบไฟล์เอกสารตามที่กำหนด เอกสารที่เป็นสำเนาทุกฉบับต้องมีลายมือชื่อของผู้มีอำนาจลงนามรับรองสำเนาทุกแผ่น และยังไม่หมดอายุโดยนับถึงวันลงทะเบียน
    </div>

    <div class="company-form">

        <?php $form = ActiveForm::begin([
            'id' => 'registration-form',
            'options' => ['enctype' => 'multipart/form-data'],
            'enableAjaxValidation' => false,
        ]); ?>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-briefcase"></i> ข้อมูลบริษัท</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'company_registration_number', [
                            'inputOptions' => ['class' => 'form-control', 'placeholder' => 'เช่น 0105555123456'],
                            'options' => ['class' => 'form-group has-feedback'],
                            'template' => '{label}<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>{input}</div>{hint}{error}'
                        ])->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'company_name', [
                            'inputOptions' => ['class' => 'form-control', 'placeholder' => 'ชื่อบริษัทจดทะเบียน'],
                            'options' => ['class' => 'form-group has-feedback'],
                            'template' => '{label}<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>{input}</div>{hint}{error}'
                        ])->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'authorized_person', [
                            'inputOptions' => ['class' => 'form-control', 'placeholder' => 'ชื่อ-นามสกุล ผู้มีอำนาจลงนาม'],
                            'options' => ['class' => 'form-group has-feedback'],
                            'template' => '{label}<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>{input}</div>{hint}{error}'
                        ])->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'proxy_person', [
                            'inputOptions' => ['class' => 'form-control', 'placeholder' => 'ชื่อ-นามสกุล ผู้รับมอบอำนาจ'],
                            'options' => ['class' => 'form-group has-feedback'],
                            'template' => '{label}<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>{input}</div>{hint}{error}'
                        ])->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'email', [
                            'inputOptions' => ['class' => 'form-control', 'placeholder' => 'example@domain.com', 'type' => 'email'],
                            'options' => ['class' => 'form-group has-feedback'],
                            'template' => '{label}<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>{input}</div>{hint}{error}'
                        ])->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'phone', [
                            'inputOptions' => ['class' => 'form-control', 'placeholder' => '0xxxxxxxxx'],
                            'options' => ['class' => 'form-group has-feedback'],
                            'template' => '{label}<div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>{input}</div>{hint}{error}'
                        ])->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="glyphicon glyphicon-file"></i> เอกสารประกอบการลงทะเบียน</h3>
            </div>
            <div class="panel-body">
                <!-- หนังสือรับรองการจดทะเบียนนิติบุคคล -->
                <div class="row">
                    <div class="col-md-12">
                        <?= $form->field($model, 'company_certificate_upload')->widget(FileInput::classname(), [
                            'options' => [
                                'accept' => 'application/pdf',
                                'class' => 'ajax-upload'
                            ],
                            'pluginOptions' => [
                                'showPreview' => true,
                                'showCaption' => true,
                                'showRemove' => true,
                                'showUpload' => true,
                                'showCancel' => true,
                                'uploadUrl' => Url::to(['registration/register']),
                                'uploadExtraData' => [
                                    'fieldName' => 'company_certificate_file'
                                ],
                                'browseClass' => 'btn btn-primary',
                                'browseIcon' => '<i class="glyphicon glyphicon-file"></i> ',
                                'browseLabel' => 'เลือกไฟล์',
                                'allowedFileExtensions' => ['pdf'],
                                'maxFileSize' => 5120, // 5MB
                                'msgSizeTooLarge' => 'ไฟล์ "{name}" ({size} KB) มีขนาดเกินขนาดสูงสุดที่อนุญาต {maxSize} KB',
                                'msgInvalidFileExtension' => 'นามสกุลไฟล์ "{name}" ไม่ถูกต้อง อนุญาตเฉพาะไฟล์ "{extensions}"',
                                'dropZoneTitle' => 'ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเลือกไฟล์...',
                                'dropZoneClickTitle' => '<br>(หรือคลิกเพื่อเลือกไฟล์)',
                                'fileActionSettings' => [
                                    'showRemove' => true,
                                    'showUpload' => false,
                                    'showZoom' => true,
                                    'showDrag' => false,
                                ],
                                'previewFileType' => 'pdf',
                                'previewFileIcon' => '<i class="glyphicon glyphicon-file"></i>',
                                'previewSettings' => [
                                    'pdf' => ['width' => '100%', 'height' => '400px'],
                                ],
                                'layoutTemplates' => [
                                    'progress' => '<div class="kv-upload-progress"><div class="progress">' .
                                        '<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="{percent}" aria-valuemin="0" aria-valuemax="100" style="width:{percent}%;">' .
                                        '{percent}%' .
                                        '</div>' .
                                        '</div></div>',
                                ],
                                'uploadAsync' => true,
                            ],
                            'pluginEvents' => [
                                'fileuploaded' => 'function(event, data, previewId, index) {
                                    if (data.response.success) {
                                        $("#hidden-certificate").val(data.response.fileName);
                                        $("#file-upload-status-certificate").html("<div class=\"alert alert-success\"><i class=\"glyphicon glyphicon-ok-circle\"></i> อัพโหลดสำเร็จ: " + data.response.fileName + "</div>");
                                    } else {
                                        $("#file-upload-status-certificate").html("<div class=\"alert alert-danger\"><i class=\"glyphicon glyphicon-exclamation-sign\"></i> " + data.response.message + "</div>");
                                    }
                                }',
                                'filepreajax' => 'function(event, previewId, index) {
                                    $("#file-upload-status-certificate").html("<div class=\"alert alert-info\"><i class=\"glyphicon glyphicon-refresh glyphicon-spin\"></i> กำลังตรวจสอบไฟล์...</div>");
                                }',
                                'fileuploaderror' => 'function(event, data, msg) {
                                    $("#file-upload-status-certificate").html("<div class=\"alert alert-danger\"><i class=\"glyphicon glyphicon-exclamation-sign\"></i> " + msg + "</div>");
                                }',
                                'filebatchpreupload' => 'function(event, data) {
                                    $("#file-upload-status-certificate").html("<div class=\"alert alert-info\"><i class=\"glyphicon glyphicon-refresh glyphicon-spin\"></i> กำลังอัพโหลดไฟล์...</div>");
                                }',
                                'filebatchuploadcomplete' => 'function(event, files, extra) {
                                    console.log("File batch upload complete");
                                }',
                                'filebatchuploaderror' => 'function(event, data, msg) {
                                    $("#file-upload-status-certificate").html("<div class=\"alert alert-danger\"><i class=\"glyphicon glyphicon-exclamation-sign\"></i> " + msg + "</div>");
                                }',
                                'fileprogress' => 'function(event, data, previewId, index) {
                                    var pct = Math.floor(data.loaded * 100 / data.total);
                                    $("#file-upload-status-certificate").html("<div class=\"alert alert-info\"><i class=\"glyphicon glyphicon-refresh glyphicon-spin\"></i> กำลังอัพโหลด: " + pct + "%</div>");
                                }',
                                'filepreupload' => 'function(event, data, previewId, index) {
                                    var file = data.files[0];
                                    if (file.size > 5120000) {
                                        return {
                                            message: "ขนาดไฟล์เกิน 5MB",
                                            data: {
                                                "error": "ขนาดไฟล์เกิน 5MB"
                                            }
                                        };
                                    }
                                    if (file.type !== "application/pdf") {
                                        return {
                                            message: "อนุญาตเฉพาะไฟล์ PDF เท่านั้น",
                                            data: {
                                                "error": "อนุญาตเฉพาะไฟล์ PDF เท่านั้น"
                                            }
                                        };
                                    }
                                }',
                            ],
                        ]); ?>
                        <?= Html::hiddenInput('Company[company_certificate_file]', '', ['id' => 'hidden-certificate']) ?>
                        <div id="file-upload-status-certificate" class="upload-status"></div>
                        <div class="help-block">
                            <small><i class="glyphicon glyphicon-info-sign"></i> หนังสือรับรองการจดทะเบียนนิติบุคคล (ไฟล์ PDF ขนาดไม่เกิน 5MB)</small>
                        </div>
                    </div>
                </div>
                
                <!-- หนังสือมอบอำนาจ -->
                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-12">
                        <?= $form->field($model, 'proxy_upload')->widget(FileInput::classname(), [
                            'options' => [
                                'accept' => 'application/pdf',
                                'class' => 'ajax-upload'
                            ],
                            'pluginOptions' => [
                                'showPreview' => true,
                                'showCaption' => true,
                                'showRemove' => true,
                                'showUpload' => true,
                                'showCancel' => true,
                                'uploadUrl' => Url::to(['registration/register']),
                                'uploadExtraData' => [
                                    'fieldName' => 'proxy_file'
                                ],
                                'browseClass' => 'btn btn-primary',
                                'browseIcon' => '<i class="glyphicon glyphicon-file"></i> ',
                                'browseLabel' => 'เลือกไฟล์',
                                'allowedFileExtensions' => ['pdf'],
                                'maxFileSize' => 5120, // 5MB
                                'msgSizeTooLarge' => 'ไฟล์ "{name}" ({size} KB) มีขนาดเกินขนาดสูงสุดที่อนุญาต {maxSize} KB',
                                'msgInvalidFileExtension' => 'นามสกุลไฟล์ "{name}" ไม่ถูกต้อง อนุญาตเฉพาะไฟล์ "{extensions}"',
                                'dropZoneTitle' => 'ลากและวางไฟล์ที่นี่ หรือคลิกเพื่อเลือกไฟล์...',
                                'dropZoneClickTitle' => '<br>(หรือคลิกเพื่อเลือกไฟล์)',
                                'fileActionSettings' => [
                                    'showRemove' => true,
                                    'showUpload' => false,
                                    'showZoom' => true,
                                    'showDrag' => false,
                                ],
                                'previewFileType' => 'pdf',
                                'previewFileIcon' => '<i class="glyphicon glyphicon-file"></i>',
                                'previewSettings' => [
                                    'pdf' => ['width' => '100%', 'height' => '400px'],
                                ],
                                'layoutTemplates' => [
                                    'progress' => '<div class="kv-upload-progress"><div class="progress">' .
                                        '<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="{percent}" aria-valuemin="0" aria-valuemax="100" style="width:{percent}%;">' .
                                        '{percent}%' .
                                        '</div>' .
                                        '</div></div>',
                                ],
                                'uploadAsync' => true,
                            ],
                            'pluginEvents' => [
                                'fileuploaded' => 'function(event, data, previewId, index) {
                                    if (data.response.success) {
                                        $("#hidden-proxy").val(data.response.fileName);
                                        $("#file-upload-status-proxy").html("<div class=\"alert alert-success\"><i class=\"glyphicon glyphicon-ok-circle\"></i> อัพโหลดสำเร็จ: " + data.response.fileName + "</div>");
                                    } else {
                                        $("#file-upload-status-proxy").html("<div class=\"alert alert-danger\"><i class=\"glyphicon glyphicon-exclamation-sign\"></i> " + data.response.message + "</div>");
                                    }
                                }',
                                'filepreajax' => 'function(event, previewId, index) {
                                    $("#file-upload-status-proxy").html("<div class=\"alert alert-info\"><i class=\"glyphicon glyphicon-refresh glyphicon-spin\"></i> กำลังตรวจสอบไฟล์...</div>");
                                }',
                                'fileuploaderror' => 'function(event, data, msg) {
                                    $("#file-upload-status-proxy").html("<div class=\"alert alert-danger\"><i class=\"glyphicon glyphicon-exclamation-sign\"></i> " + msg + "</div>");
                                }',
                                'filebatchpreupload' => 'function(event, data) {
                                    $("#file-upload-status-proxy").html("<div class=\"alert alert-info\"><i class=\"glyphicon glyphicon-refresh glyphicon-spin\"></i> กำลังอัพโหลดไฟล์...</div>");
                                }',
                                'fileprogress' => 'function(event, data, previewId, index) {
                                    var pct = Math.floor(data.loaded * 100 / data.total);
                                    $("#file-upload-status-proxy").html("<div class=\"alert alert-info\"><i class=\"glyphicon glyphicon-refresh glyphicon-spin\"></i> กำลังอัพโหลด: " + pct + "%</div>");
                                }',
                                'filepreupload' => 'function(event, data, previewId, index) {
                                    var file = data.files[0];
                                    if (file.size > 5120000) {
                                        return {
                                            message: "ขนาดไฟล์เกิน 5MB",
                                            data: {
                                                "error": "ขนาดไฟล์เกิน 5MB"
                                            }
                                        };
                                    }
                                    if (file.type !== "application/pdf") {
                                        return {
                                            message: "อนุญาตเฉพาะไฟล์ PDF เท่านั้น",
                                            data: {
                                                "error": "อนุญาตเฉพาะไฟล์ PDF เท่านั้น"
                                            }
                                        };
                                    }
                                }',
                            ],
                        ]); ?>
                        <?= Html::hiddenInput('Company[proxy_file]', '', ['id' => 'hidden-proxy']) ?>
                        <div id="file-upload-status-proxy" class="upload-status"></div>
                        <div class="help-block">
                            <small><i class="glyphicon glyphicon-info-sign"></i> หนังสือมอบอำนาจ (ไฟล์ PDF ขนาดไม่เกิน 5MB)</small>
                        </div>
                    </div>
                </div>
                
                <!-- สำเนาบัตรประชาชน -->
                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-6">
                        <?= $form->field($model, 'authorized_person_id_upload')->widget(FileInput::classname(), [
                            'options' => [
                                'accept' => 'application/pdf',
                                'class' => 'ajax-upload'
                            ],
                            'pluginOptions' => [
                                'showPreview' => true,
                                'showCaption' => true,
                                'showRemove' => true,
                                'showUpload' => true,
                                'showCancel' => true,
                                'uploadUrl' => Url::to(['registration/register']),
                                'uploadExtraData' => [
                                    'fieldName' => 'authorized_person_id_file'
                                ],
                                'browseClass' => 'btn btn-primary',
                                'browseIcon' => '<i class="glyphicon glyphicon-file"></i> ',
                                'browseLabel' => 'เลือกไฟล์',
                                'allowedFileExtensions' => ['pdf'],
                                'maxFileSize' => 5120, // 5MB
                                'msgSizeTooLarge' => 'ไฟล์ "{name}" ({size} KB) มีขนาดเกินขนาดสูงสุดที่อนุญาต {maxSize} KB',
                                'msgInvalidFileExtension' => 'นามสกุลไฟล์ "{name}" ไม่ถูกต้อง อนุญาตเฉพาะไฟล์ "{extensions}"',
                                'dropZoneTitle' => 'ลากและวางไฟล์ที่นี่',
                                'dropZoneClickTitle' => '<br>(หรือคลิกเพื่อเลือกไฟล์)',
                                'fileActionSettings' => [
                                    'showRemove' => true,
                                    'showUpload' => false,
                                    'showZoom' => true,
                                    'showDrag' => false,
                                ],
                                'previewFileType' => 'pdf',
                                'previewFileIcon' => '<i class="glyphicon glyphicon-file"></i>',
                                'previewSettings' => [
                                    'pdf' => ['width' => '100%', 'height' => '300px'],
                                ],
                                'layoutTemplates' => [
                                    'progress' => '<div class="kv-upload-progress"><div class="progress">' .
                                        '<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="{percent}" aria-valuemin="0" aria-valuemax="100" style="width:{percent}%;">' .
                                        '{percent}%' .
                                        '</div>' .
                                        '</div></div>',
                                ],
                                'uploadAsync' => true,
                            ],
                            'pluginEvents' => [
                                'fileuploaded' => 'function(event, data, previewId, index) {
                                    if (data.response.success) {
                                        $("#hidden-auth-id").val(data.response.fileName);
                                        $("#file-upload-status-auth-id").html("<div class=\"alert alert-success\"><i class=\"glyphicon glyphicon-ok-circle\"></i> อัพโหลดสำเร็จ</div>");
                                    } else {
                                        $("#file-upload-status-auth-id").html("<div class=\"alert alert-danger\"><i class=\"glyphicon glyphicon-exclamation-sign\"></i> " + data.response.message + "</div>");
                                    }
                                }',
                                'filepreajax' => 'function(event, previewId, index) {
                                    $("#file-upload-status-auth-id").html("<div class=\"alert alert-info\"><i class=\"glyphicon glyphicon-refresh glyphicon-spin\"></i> กำลังตรวจสอบไฟล์...</div>");
                                }',
                                'fileuploaderror' => 'function(event, data, msg) {
                                    $("#file-upload-status-auth-id").html("<div class=\"alert alert-danger\"><i class=\"glyphicon glyphicon-exclamation-sign\"></i> " + msg + "</div>");
                                }',
                                'filebatchpreupload' => 'function(event, data) {
                                    $("#file-upload-status-auth-id").html("<div class=\"alert alert-info\"><i class=\"glyphicon glyphicon-refresh glyphicon-spin\"></i> กำลังอัพโหลดไฟล์...</div>");
                                }',
                                'fileprogress' => 'function(event, data, previewId, index) {
                                    var pct = Math.floor(data.loaded * 100 / data.total);
                                    $("#file-upload-status-auth-id").html("<div class=\"alert alert-info\"><i class=\"glyphicon glyphicon-refresh glyphicon-spin\"></i> กำลังอัพโหลด: " + pct + "%</div>");
                                }',
                                'filepreupload' => 'function(event, data, previewId, index) {
                                    var file = data.files[0];
                                    if (file.size > 5120000) {
                                        return {
                                            message: "ขนาดไฟล์เกิน 5MB",
                                            data: {
                                                "error": "ขนาดไฟล์เกิน 5MB"
                                            }
                                        };
                                    }
                                    if (file.type !== "application/pdf") {
                                        return {
                                            message: "อนุญาตเฉพาะไฟล์ PDF เท่านั้น",
                                            data: {
                                                "error": "อนุญาตเฉพาะไฟล์ PDF เท่านั้น"
                                            }
                                        };
                                    }
                                }',
                            ],
                        ]); ?>
                        <?= Html::hiddenInput('Company[authorized_person_id_file]', '', ['id' => 'hidden-auth-id']) ?>
                        <div id="file-upload-status-auth-id" class="upload-status"></div>
                        <div class="help-block">
                            <small><i class="glyphicon glyphicon-info-sign"></i> สำเนาบัตรประชาชนของผู้มีอำนาจลงนาม พร้อมลงนามรับรองสำเนา (ไฟล์ PDF ขนาดไม่เกิน 5MB)</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'proxy_person_id_upload')->widget(FileInput::classname(), [
                            'options' => [
                                'accept' => 'application/pdf',
                                'class' => 'ajax-upload'
                            ],
                            'pluginOptions' => [
                                'showPreview' => true,
                                'showCaption' => true,
                                'showRemove' => true,
                                'showUpload' => true,
                                'showCancel' => true,
                                'uploadUrl' => Url::to(['registration/register']),
                                'uploadExtraData' => [
                                    'fieldName' => 'proxy_person_id_file'
                                ],
                                'browseClass' => 'btn btn-primary',
                                'browseIcon' => '<i class="glyphicon glyphicon-file"></i> ',
                                'browseLabel' => 'เลือกไฟล์',
                                'allowedFileExtensions' => ['pdf'],
                                'maxFileSize' => 5120, // 5MB
                                'msgSizeTooLarge' => 'ไฟล์ "{name}" ({size} KB) มีขนาดเกินขนาดสูงสุดที่อนุญาต {maxSize} KB',
                                'msgInvalidFileExtension' => 'นามสกุลไฟล์ "{name}" ไม่ถูกต้อง อนุญาตเฉพาะไฟล์ "{extensions}"',
                                'dropZoneTitle' => 'ลากและวางไฟล์ที่นี่',
                                'dropZoneClickTitle' => '<br>(หรือคลิกเพื่อเลือกไฟล์)',
                                'fileActionSettings' => [
                                    'showRemove' => true,
                                    'showUpload' => false,
                                    'showZoom' => true,
                                    'showDrag' => false,
                                ],
                                'previewFileType' => 'pdf',
                                'previewFileIcon' => '<i class="glyphicon glyphicon-file"></i>',
                                'previewSettings' => [
                                    'pdf' => ['width' => '100%', 'height' => '300px'],
                                ],
                                'layoutTemplates' => [
                                    'progress' => '<div class="kv-upload-progress"><div class="progress">' .
                                        '<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="{percent}" aria-valuemin="0" aria-valuemax="100" style="width:{percent}%;">' .
                                        '{percent}%' .
                                        '</div>' .
                                        '</div></div>',
                                ],
                                'uploadAsync' => true,
                            ],
                            'pluginEvents' => [
                                'fileuploaded' => 'function(event, data, previewId, index) {
                                    if (data.response.success) {
                                        $("#hidden-proxy-id").val(data.response.fileName);
                                        $("#file-upload-status-proxy-id").html("<div class=\"alert alert-success\"><i class=\"glyphicon glyphicon-ok-circle\"></i> อัพโหลดสำเร็จ</div>");
                                    } else {
                                        $("#file-upload-status-proxy-id").html("<div class=\"alert alert-danger\"><i class=\"glyphicon glyphicon-exclamation-sign\"></i> " + data.response.message + "</div>");
                                    }
                                }',
                                'filepreajax' => 'function(event, previewId, index) {
                                    $("#file-upload-status-proxy-id").html("<div class=\"alert alert-info\"><i class=\"glyphicon glyphicon-refresh glyphicon-spin\"></i> กำลังตรวจสอบไฟล์...</div>");
                                }',
                                'fileuploaderror' => 'function(event, data, msg) {
                                    $("#file-upload-status-proxy-id").html("<div class=\"alert alert-danger\"><i class=\"glyphicon glyphicon-exclamation-sign\"></i> " + msg + "</div>");
                                }',
                                'filebatchpreupload' => 'function(event, data) {
                                    $("#file-upload-status-proxy-id").html("<div class=\"alert alert-info\"><i class=\"glyphicon glyphicon-refresh glyphicon-spin\"></i> กำลังอัพโหลดไฟล์...</div>");
                                }',
                                'fileprogress' => 'function(event, data, previewId, index) {
                                    var pct = Math.floor(data.loaded * 100 / data.total);
                                    $("#file-upload-status-proxy-id").html("<div class=\"alert alert-info\"><i class=\"glyphicon glyphicon-refresh glyphicon-spin\"></i> กำลังอัพโหลด: " + pct + "%</div>");
                                }',
                                'filepreupload' => 'function(event, data, previewId, index) {
                                    var file = data.files[0];
                                    if (file.size > 5120000) {
                                        return {
                                            message: "ขนาดไฟล์เกิน 5MB",
                                            data: {
                                                "error": "ขนาดไฟล์เกิน 5MB"
                                            }
                                        };
                                    }
                                    if (file.type !== "application/pdf") {
                                        return {
                                            message: "อนุญาตเฉพาะไฟล์ PDF เท่านั้น",
                                            data: {
                                                "error": "อนุญาตเฉพาะไฟล์ PDF เท่านั้น"
                                            }
                                        };
                                    }
                                }',
                            ],
                        ]); ?>
                        <?= Html::hiddenInput('Company[proxy_person_id_file]', '', ['id' => 'hidden-proxy-id']) ?>
                        <div id="file-upload-status-proxy-id" class="upload-status"></div>
                        <div class="help-block">
                            <small><i class="glyphicon glyphicon-info-sign"></i> สำเนาบัตรประชาชนของผู้รับมอบอำนาจ พร้อมลงนามรับรองสำเนา (ไฟล์ PDF ขนาดไม่เกิน 5MB)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            <?= Html::submitButton('<i class="glyphicon glyphicon-send"></i> ลงทะเบียน', [
                'class' => 'btn btn-success btn-lg',
                'id' => 'submit-btn',
                'onclick' => 'return validateFiles();'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<!-- แสดงสถานะการอัพโหลดแบบลอย -->
<div id="upload-status-floating" style="display: none; position: fixed; bottom: 20px; right: 20px; z-index: 9999; background-color: #333; color: white; padding: 15px; border-radius: 5px; box-shadow: 0 3px 10px rgba(0,0,0,0.2);">
    <span id="upload-status-text">กำลังอัพโหลด: 0%</span>
    <div class="progress" style="margin-top: 10px; margin-bottom: 0;">
        <div id="upload-progress-bar" class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" style="width: 0%"></div>
    </div>
</div>

<?php
// เพิ่ม JavaScript สำหรับตรวจสอบการอัพโหลดไฟล์และแสดงสถานะ
$js = <<<JS
// ฟังก์ชันตรวจสอบไฟล์ก่อนส่งฟอร์ม
function validateFiles() {
    var missingFiles = [];
    
    if ($("#hidden-certificate").val() === '') {
        missingFiles.push("หนังสือรับรองการจดทะเบียนนิติบุคคล");
    }
    
    if ($("#hidden-proxy").val() === '') {
        missingFiles.push("หนังสือมอบอำนาจ");
    }
    
    if ($("#hidden-auth-id").val() === '') {
        missingFiles.push("สำเนาบัตรประชาชนของผู้มีอำนาจลงนาม");
    }
    
    if ($("#hidden-proxy-id").val() === '') {
        missingFiles.push("สำเนาบัตรประชาชนของผู้รับมอบอำนาจ");
    }
    
    if (missingFiles.length > 0) {
        // ใช้ SweetAlert ถ้ามี หรือ alert ธรรมดาถ้าไม่มี
        if (typeof swal !== 'undefined') {
            swal({
                title: "กรุณาอัพโหลดไฟล์ให้ครบถ้วน",
                text: "กรุณาอัพโหลดไฟล์ต่อไปนี้ก่อนลงทะเบียน:\\n- " + missingFiles.join("\\n- "),
                type: "warning",
                confirmButtonText: "ตกลง",
                html: true
            });
        } else {
            alert("กรุณาอัพโหลดไฟล์ต่อไปนี้ก่อนลงทะเบียน:\\n- " + missingFiles.join("\\n- "));
        }
        return false;
    }
    
    // ใช้ SweetAlert ถ้ามี
    if (typeof swal !== 'undefined') {
        swal({
            title: "กำลังประมวลผล",
            text: "กรุณารอสักครู่...",
            showConfirmButton: false,
            allowOutsideClick: false,
            html: true
        });
    }
    
    return true;
}

// ฟังก์ชันตรวจสอบไฟล์ PDF
function validatePdfFile(file) {
    if (file.type !== "application/pdf") {
        return {
            valid: false,
            message: "อนุญาตเฉพาะไฟล์ PDF เท่านั้น"
        };
    }
    
    if (file.size > 5242880) { // 5MB = 5 * 1024 * 1024
        return {
            valid: false,
            message: "ขนาดไฟล์เกิน 5MB"
        };
    }
    
    return {
        valid: true
    };
}

// ฟังก์ชันแสดงตัวอย่างไฟล์ PDF
function showPdfPreview(file, previewElement) {
    var reader = new FileReader();
    reader.onload = function(e) {
        var pdfPreview = '<object data="' + e.target.result + '" type="application/pdf" width="100%" height="300px">';
        pdfPreview += 'ไม่สามารถแสดงไฟล์ PDF ได้ <a href="' + e.target.result + '" target="_blank">คลิกที่นี่เพื่อเปิดไฟล์</a>';
        pdfPreview += '</object>';
        $(previewElement).html(pdfPreview);
    };
    reader.readAsDataURL(file);
}

// ฟังก์ชันแสดงการอัพโหลดแบบลอย
function showFloatingUploadStatus(show, percent) {
    if (show) {
        $("#upload-status-floating").show();
        $("#upload-status-text").text("กำลังอัพโหลด: " + percent + "%");
        $("#upload-progress-bar").css("width", percent + "%");
    } else {
        // ซ่อนหลังจาก 2 วินาที
        setTimeout(function() {
            $("#upload-status-floating").hide();
        }, 2000);
    }
}

// เพิ่มการจับเหตุการณ์อัพโหลดไฟล์ทั้งหมด
$(".ajax-upload").on('fileuploading', function(event, data, previewId, index) {
    var percent = Math.floor(data.loaded * 100 / data.total);
    showFloatingUploadStatus(true, percent);
});

$(".ajax-upload").on('fileuploaded', function(event, data, previewId, index) {
    showFloatingUploadStatus(false);
});

$(".ajax-upload").on('fileuploaderror', function(event, data, msg) {
    showFloatingUploadStatus(false);
});

// ปรับปรุง UI เมื่อลากไฟล์เข้ามา
$(document).on('dragover', '.file-drop-zone', function() {
    $(this).addClass('highlighted');
});

$(document).on('dragleave', '.file-drop-zone', function() {
    $(this).removeClass('highlighted');
});

$(document).on('drop', '.file-drop-zone', function() {
    $(this).removeClass('highlighted');
});

// เพิ่มการตรวจสอบสถานะการอัพโหลดไฟล์ทุก 1 วินาที
setInterval(function() {
    if ($("#hidden-certificate").val() !== '') {
        $("#file-upload-status-certificate").html("<div class=\"alert alert-success\"><i class=\"glyphicon glyphicon-ok-circle\"></i> อัพโหลดสำเร็จ</div>");
    }
    
    if ($("#hidden-proxy").val() !== '') {
        $("#file-upload-status-proxy").html("<div class=\"alert alert-success\"><i class=\"glyphicon glyphicon-ok-circle\"></i> อัพโหลดสำเร็จ</div>");
    }
    
    if ($("#hidden-auth-id").val() !== '') {
        $("#file-upload-status-auth-id").html("<div class=\"alert alert-success\"><i class=\"glyphicon glyphicon-ok-circle\"></i> อัพโหลดสำเร็จ</div>");
    }
    
    if ($("#hidden-proxy-id").val() !== '') {
        $("#file-upload-status-proxy-id").html("<div class=\"alert alert-success\"><i class=\"glyphicon glyphicon-ok-circle\"></i> อัพโหลดสำเร็จ</div>");
    }
}, 1000);

// เพิ่ม animation ให้กับปุ่มเมื่อผู้ใช้โฮเวอร์
$("#submit-btn").hover(
    function() {
        $(this).addClass("animated pulse");
    },
    function() {
        $(this).removeClass("animated pulse");
    }
);

// เพิ่ม library animation สำหรับ pulse effect
if ($('head').find('link[href*="animate.css"]').length === 0) {
    $('head').append('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css" type="text/css" />');
}

// เพิ่ม SweetAlert ถ้ายังไม่มี
if (typeof swal === 'undefined' && $('head').find('script[src*="sweetalert"]').length === 0) {
    $('head').append('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" type="text/css" />');
    $('body').append('<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>');
}
JS;

$this->registerJs($js);
?>