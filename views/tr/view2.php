<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Modal;
use kartik\detail\DetailView;
use kartik\grid\GridView;
use yii2ajaxcrud\ajaxcrud\CrudAsset;
use yii2ajaxcrud\ajaxcrud\BulkButtonWidget;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model app\models\MacTestVehCertDetail */

CrudAsset::register($this);
$this->title = 'เลขที่หนังสืออนุญาต ' . $model->certNo . ' เลขที่เครื่องหมาย ' . $model->plate;
?>
<div class="mac-test-veh-cert-detail-view">
    <style>
        .table.detail-view tbody tr td {
            width: 30%;
            /* กำหนดให้คอลัมน์แต่ละอันมีขนาด 50% */
        }
    </style>
    <h4 class="fw-bold">รายงานการใช้เครื่องหมายรถทดสอบคุณภาพ (QC) <?php echo $this->title; ?></h4>
    <hr />
    <div class="card">
        <div class="card-header bg-primary text-white">
            <?= $this->title; ?>
        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-striped table-bordered detail-view'], // กำหนด class CSS
                'attributes' => [
                    [
                        'columns' => [
                            [
                                'label' => 'ประเภทรถทดสอบ',
                                'value' => $model->carTestType,
                            ],
                            [
                                'label' => 'เลขที่หนังสืออนุญาต',
                                'value' => $model->certNo,
                            ],
                        ]
                    ],
                    [
                        'columns' => [
                            [
                                'label' => 'ประเภทรถ',
                                'value' => $model->carType,
                            ],
                            [
                                'label' => 'เลขที่เครื่องหมาย',
                                'format' => 'raw',
                                'value' => $model->plate,
                            ],
                        ]
                    ],
                    [
                        'columns' => [
                            [
                                'label' => 'หมายเลขตัวรถ',
                                'value' => $model->NUM_BODY != null ? $model->NUM_BODY : '-',
                            ],
                            [
                                'label' => 'หมายเลขเครื่องยนต์',
                                'value' => $model->NUM_ENG != null ? $model->NUM_ENG : '-',
                            ],
                        ]
                    ],
                    [
                        'columns' => [
                            [
                                'label' => 'รุ่นรถ',
                                'value' => $model->SERIES_NAME != null ? $model->SERIES_NAME : '-',
                            ],
                            [
                                'label' => 'วันที่ยกเลิกใช้รถทดสอบ',
                                'value' => $model->STOP_USE_DATE != null ? \app\models\MyDate::getDateThai($model->STOP_USE_DATE) : '-',
                            ],
                        ]
                    ],
                    [
                        'columns' => [
                            [
                                'label' => 'การส่งคืนเครื่องหมาย',
                                'value' => $model->sendBackFlag != null ? $model->sendBackFlag : '-',
                            ],
                            [
                                'label' => 'วันที่การส่งคืนเครื่องหมาย',
                                'value' => $model->SEND_BACK_DATE != null ? \app\models\MyDate::getDateThai($model->SEND_BACK_DATE) : '-',
                                'valueColOptions' => ['style' => 'width:30%'],
                            ],
                        ]
                    ],
                    /*
        [
            'columns' => [
                [
                    'label' => 'ต้องรายงานข้อมูล',
                    'format' => 'html',
                    'value' => $model->macTestVehCert->getReportDates(),
                ],
                [
                    'label' => '',
                    'value' => '',
                ],
            ]
        ],
        */
                ],
            ]) ?>

        </div>
    </div>

</div>
<hr />
<div id="ajaxCrudDatatable">
    <?php
    echo GridView::widget([
        'id' => 'crud-datatable',
        'dataProvider' => $modelSchedule,
        //'filterModel' => $searchModel,
        'panel' => [
            'type' => 'warning',
            'heading' => '<i class="fa fa-list"></i> ตารางงานการใช้เครื่องหมายรถทดสอบคุณภาพ (QC)',
            'before' => '', // ลบข้อความ Summary ออก
        ],
        'layout' => '{items}{pager}',
        'summary' => 'แสดง {begin}-{end} รายการ จากทั้งหมด {totalCount} รายการ',
        'toolbar' => false,
        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'ลำดับ'
            ],
            [
                'header' => 'ประเภทรถทดสอบ',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->CarTestType;
                },
            ],

            [
                'header' => 'ทะเบียน',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->Plate;
                },
            ],
            [
                'header' => 'รอบวันที่',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->report_date;
                },
            ],
            [
                'attribute' => 'report_status',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->report_status;
                },
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'dropdown' => false,
                'noWrap' => 'true',
                'template' => '{view} {update} {delete}',
                'vAlign' => 'middle',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return Url::to(["veh-test-report-schedule/$action", 'id' => $key]);
                },
                'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-outline-success'],
                'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-outline-primary'],
                'deleteOptions' => [
                    'role' => 'modal-remote',
                    'title' => 'Delete',
                    'class' => 'btn btn-sm btn-outline-danger',
                    'data-confirm' => false,
                    'data-method' => false, // override Yii data API
                    'data-request-method' => 'post',
                    'data-toggle' => 'tooltip',
                    'data-confirm-title' => 'Delete',
                    'data-confirm-message' => 'Delete Confirm'
                ],
            ],
        ],
    ]);
    ?>
</div>
<?php Modal::begin([
    "id" => "ajaxCrudModal",
    "size" => Modal::SIZE_EXTRA_LARGE, // Set the modal size to large
    "footer" => "", // always need it for jquery plugin
    'headerOptions' => [
        'class' => 'bg-warning text-black' // ใช้ Bootstrap 5 bg-info + text-white
    ],
    "clientOptions" => [
        "tabindex" => false,
        "backdrop" => "static",
        "keyboard" => false,
    ],
    "options" => [
        "tabindex" => false
    ]
]) ?>
<?php Modal::end(); ?>