<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\detail\DetailView;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $model app\models\MacTestVehCertDetail */
?>
<div class="mac-test-veh-cert-detail-view">
    <style>
        .table.detail-view tbody tr td {
            width: 30%;
            /* กำหนดให้คอลัมน์แต่ละอันมีขนาด 50% */
        }
    </style>

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
<hr />
<?php
echo GridView::widget([
    'dataProvider' => $modelSchedule,
    //'filterModel' => $searchModel,
    'panel' => [
        'type' => 'primary',
        'heading' => '<i class="fa fa-list"></i> ตารางงานการใช้เครื่องหมายรถทดสอบคุณภาพ (QC)',
        'before' => '', // ลบข้อความ Summary ออก
        'size' => 'large', // เพิ่มการตั้งค่าขนาดเป็น large
    ],
    'layout' => '{items}{pager}',
    'summary' => 'แสดง {begin}-{end} รายการ จากทั้งหมด {totalCount} รายการ',
    'toolbar' => false,
    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'header' => 'ลำดับ',
            'headerOptions' => ['class' => 'text-center'], // จัดกึ่งกลางหัวข้อคอลัมน์
            'contentOptions' => ['class' => 'text-center'], // จัดกึ่งกลางค่าภายในคอลัมน์
        ],
        [
            'header' => 'รอบวันที่',
            'headerOptions' => ['class' => 'text-center'],
            'value' => function ($model, $key, $index, $widget) {
                return $model->report_date;
            },
        ],
        [
            'header' => 'วันที่บันทึกรายงาน',
            'headerOptions' => ['class' => 'text-center'],
            'value' => function ($model, $key, $index, $widget) {
                return $model->actual_report_date;
            },
        ],
        [
            'attribute' => 'report_status',
            'format' => 'raw',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'value' => function ($model, $key, $index, $widget) {
                return $model->getReportFlag();
            },
        ],
        [
            'header' => 'ช่วงเวลาทดสอบ',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'value' => function ($model, $key, $index, $widget) {
                return @$model->vehTestReporSchecdule->test_date_from . ' - ' . @$model->vehTestReporSchecdule->test_date_to;
            },
        ],
        [
            'header' => 'ระยะทางที่ใช้ทดสอบ<br/>ในเดือนนี้ (กิโลเมตร)',
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['class' => 'text-center'],
            'value' => function ($model, $key, $index, $widget) {
                return @$model->vehTestReporSchecdule->test_distance;
            },
        ],
        [
            'header' => 'เวลาที่ใช้ทดสอบ<br/>ในเดือนนี้ (ชั่วโมง)',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-center'],
            'value' => function ($model, $key, $index, $widget) {
                return @$model->vehTestReporSchecdule->test_time;
            },
        ],
        /*
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
        ],*/
    ],
]);
?>