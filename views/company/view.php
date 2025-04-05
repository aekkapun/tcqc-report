<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Company */

$this->title = $model->company_name;
$this->params['breadcrumbs'][] = ['label' => 'รายการบริษัท', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

// สร้างฟังก์ชันแสดงสถานะ
function getStatusLabel($status)
{
    $statusLabels = [
        0 => '<span class="label label-warning">รอตรวจสอบ</span>',
        1 => '<span class="label label-success">อนุมัติแล้ว</span>',
        2 => '<span class="label label-danger">ไม่อนุมัติ</span>',
    ];
    return $statusLabels[$status] ?? '<span class="label label-default">ไม่ระบุ</span>';
}

// สร้างฟังก์ชันแสดงลิงก์ไฟล์
function getFileLink($model, $fileField, $labelField)
{
    if (!empty($model->$fileField)) {
        return Html::a(
            '<i class="glyphicon glyphicon-file"></i> ดาวน์โหลด ' . $model->getAttributeLabel($labelField),
            ['download', 'field' => $fileField],
            ['class' => 'btn btn-info btn-sm', 'target' => '_blank']
        );
    }
    return '<span class="text-muted">ไม่มีไฟล์</span>';
}
?>
<div class="company-view">




    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                  <?= $this->title ?>
                </div>
                <div class="card-body">
                <p class="pull-right">
        <?= Html::a('แก้ไข', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('ลบ', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'คุณแน่ใจหรือไม่ที่จะลบรายการนี้?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
                <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'company_registration_number',
                    'company_name',
                    'authorized_person',
                    'proxy_person',
                    'email:email',
                    'phone',
                    [
                        'attribute' => 'status',
                        'format' => 'raw',
                        'value' => getStatusLabel($model->status),
                    ],
                    [
                        'attribute' => 'created_at',
                        'value' => function ($model) {
                            return Yii::$app->formatter->asDatetime($model->created_at);
                        },
                    ],
                    [
                        'attribute' => 'updated_at',
                        'value' => function ($model) {
                            return Yii::$app->formatter->asDatetime($model->updated_at);
                        },
                    ],
                ],
            ]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card">
                <div class="card-header bg-success text-white">เอกสาร Pdf ที่แนบมา</div>
                <div class="card-body">
                    <?php
                    // Display PDFs only
                    if (!empty($pdfs)) {
                        echo '<ul class="list-group">';
                        foreach ($pdfs as $pdf) {
                            echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                            echo Html::a($pdf['options']['title'], $pdf['url'], ['target' => '_blank']);
                            echo '<span class="badge bg-danger rounded-pill">PDF</span>';
                            echo '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo '<p class="text-danger">No PDFs found.</p>';
                    }
                    ?>
                </div>
            </div>

            <?php if ($model->status == $model::STATUS_PENDING): ?>
                <div class="card card">
                    <div class="card-header bg-primary text-white">การอนุมัติ</div>
                    <div class="panel-body">
                        <?= Html::a('อนุมัติ', ['approve', 'id' => $model->id], [
                            'class' => 'btn btn-success btn-block',
                            'data' => [
                                'confirm' => 'คุณแน่ใจหรือไม่ที่จะอนุมัติบริษัทนี้?',
                                'method' => 'post',
                            ],
                        ]) ?>

                        <?= Html::a('ไม่อนุมัติ', ['reject', 'id' => $model->id], [
                            'class' => 'btn btn-danger btn-block',
                            'data' => [
                                'confirm' => 'คุณแน่ใจหรือไม่ที่จะไม่อนุมัติบริษัทนี้?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .panel {
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 20px;
    }

    .panel-heading {
        padding: 10px 15px;
        background-color: #f5f5f5;
        border-bottom: 1px solid #ddd;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
    }

    .panel-title {
        margin-top: 0;
        margin-bottom: 0;
        font-size: 16px;
        color: inherit;
    }

    .panel-body {
        padding: 15px;
    }

    .file-item {
        margin-bottom: 10px;
    }

    .label {
        display: inline;
        padding: .2em .6em .3em;
        font-size: 75%;
        font-weight: 700;
        line-height: 1;
        color: #fff;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: .25em;
    }

    .label-success {
        background-color: #5cb85c;
    }

    .label-warning {
        background-color: #f0ad4e;
    }

    .label-danger {
        background-color: #d9534f;
    }

    .label-default {
        background-color: #777;
    }

    .btn-sm {
        padding: 5px 10px;
        font-size: 12px;
        line-height: 1.5;
        border-radius: 3px;
    }
</style>