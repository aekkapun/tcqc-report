<?php

use yii\helpers\Url;

return [
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
        'header' => 'สถานะ',
        'format' => 'raw',
        'headerOptions' => ['class' => 'text-center'],
        'contentOptions' => ['class' => 'text-left'],
        'value' => function ($model, $key, $index, $widget) {
            return $model->getReportFlag();
            //return $model::optsReportStatus()[$model->report_status] ?? '-';
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
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'noWrap' => 'true',
        'template' => '{update}',
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to(['veh-test-report-schedule/' . $action, 'id' => $key]);
        },
        'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-outline-success'],
        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-outline-primary'],
        'deleteOptions' => [
            'role' => 'modal-remote',
            'title' => 'Delete',
            'class' => 'btn btn-sm btn-outline-danger',
            'data-confirm' => false,
            'data-method' => false, // for override yii data api
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Delete',
            'data-confirm-message' => 'Delete Confirm'
        ],
    ],

];
