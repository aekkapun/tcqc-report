<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
?>
<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'layout' => '{items}{pager}',
    'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
    'responsive' => true,
    'responsiveWrap' => false,
    'rowOptions' => function ($model, $key, $index, $grid) {
        return ['style' => 'background-color:#FFEBD1FF']; // สีฟ้าอ่อน
    },

    'striped' => true,
    'hover' => true,
    'floatHeader' => false,
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
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($model, $key, $index, $widget) {
                return $model->getReportFlag();
            },
        ],
        [
            'header' => 'ช่วงเวลาทดสอบ',
            'headerOptions' => ['class' => 'text-center'],
            'contentOptions' => ['class' => 'text-left'],
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
        /* [
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