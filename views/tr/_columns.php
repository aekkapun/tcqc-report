<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;

return [
    [
        'class' => 'yii\grid\SerialColumn',
        'header' => 'ลำดับ',
        'headerOptions' => ['class' => 'text-center'], // จัดกึ่งกลางหัวข้อคอลัมน์
        'contentOptions' => ['class' => 'text-center'], // จัดกึ่งกลางค่าภายในคอลัมน์
    ],
    [
        'class' => 'kartik\grid\ExpandRowColumn',
        'value' => function ($model, $key, $index, $column) {
            return GridView::ROW_COLLAPSED;
        },
        'detail' => function ($model, $key, $index, $column) {
            $searchModel = new \app\models\VehTestReportScheduleSearch();
            $searchModel->OFF_CODE = $model->OFF_CODE;
            $searchModel->BR_CODE = $model->BR_CODE;
            $searchModel->CAR_TEST_TYPE = $model->CAR_TEST_TYPE;
            $searchModel->CERT_YEAR = $model->CERT_YEAR;
            $searchModel->CERT_NO = $model->CERT_NO;
            $searchModel->PLATE1 = $model->PLATE1;
            $searchModel->PLATE2 = $model->PLATE2;

            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return Yii::$app->controller->renderPartial('_items', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        },
    ],
    /*
            [
                'label'=>'ผู้ขออนุญาต',
                'value' => function ($model, $key, $index) {
                    return @$model->macTestVehCert->fullName;
                },
            ],
            */
    [
        'label' => 'เลขที่หนังสืออนุญาต',
        'attribute' => 'CERT_NO',
        'value' => function ($model, $key, $index) {
            return $model->certNo;
        },
    ],
    [
        'label' => 'ประเภทรถ',
        'value' => function ($model, $key, $index) {
            return $model->carType;
        },
    ],
    [
        'label' => 'เครื่องหมาย',
        'format' => 'html',
        'attribute' => 'PLATE2',
        'value' => function ($model, $key, $index) {
            return $model->plate;
        },
    ],
    [
        'header' => 'สถานะ',
        'headerOptions' => ['class' => 'text-center'], // จัดกึ่งกลางหัวข้อคอลัมน์
        'contentOptions' => ['class' => 'text-center'], // จัดกึ่งกลางค่าภายในคอลัมน์
        'format' => 'html',
        'attribute' => 'PLATE2',
        'value' => function ($model, $key, $index) {
            return $model->plateCancel;
        },
    ],
    // 'PLATE_SEQ',
    'NUM_BODY',
    // 'NUM_ENG',
    /*
            [
                'label'=>'วันที่อนุญาต',
                'value' => function ($model, $key, $index) {
                    return \app\models\MyDate::getDateThai(@$model->macTestVehCert->PMT_DATE);
                },
            ],
           
            [
                'label'=>'วันที่สิ้นอายุ',
                'value' => function ($model, $key, $index) {
                    return \app\models\MyDate::getDateThai(@$model->macTestVehCert->EXP_DATE);
                },
            ],
            [
                'label'=>'การใช้รถทดสอบ',
                'format'=>'html',
                'value' => function ($model, $key, $index) {
                    return $model->reportFlag;
                },
            ],
            */
    /*  [
                'label' => 'ต้องรายงานข้อมูล',
                'format' => 'html',
                'value' => function ($model, $key, $index) {
                    $result = Yii::$app->LicenseReportCalculator->calculateReportDates(
                        \app\models\MyDate::getDateThai(@$model->macTestVehCert->PMT_DATE), 
                        \app\models\MyDate::getDateThai(@$model->macTestVehCert->EXP_DATE)
                    );
            
                    // แสดงช่วงวันที่
                    $output = "ช่วงวันที่ {$result['startDate']} - {$result['endDate']}<br>";
                    $output .= "มีทั้งหมด {$result['totalDays']} วัน<br>";
            
                    // แสดงรายการวันที่ต้องรายงาน
                    $output .= "<strong>วันที่ต้องรายงาน:</strong><br><ul>";
                    foreach ($result['reportDates'] as $index => $date) {
                        $output .= "<li>" . ($index + 1) . ". วันที่ $date</li>";
                    }
                    $output .= "</ul>";
            
                    return $output;
                },
            ],
            
    [
        'label' => 'ต้องรายงานข้อมูล',
        'format' => 'html',
        'value' => function ($model, $key, $index) {
            return $model->macTestVehCert->getReportDates();
        }
    ],*/
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'noWrap' => 'true',
        'template' => '{view} {index-report-schedule}', // เพิ่มช่องว่างระหว่าง actions
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            // แก้ไขสำหรับ index-report-schedule
            if ($action === 'index-report-schedule') {
                return Url::to([
                    'index-report-schedule',
                    'OFF_CODE' => $model->OFF_CODE,
                    'BR_CODE' => $model->BR_CODE,
                    'CAR_TEST_TYPE' => $model->CAR_TEST_TYPE,
                    'CERT_YEAR' => $model->CERT_YEAR,
                    'CERT_NO' => $model->CERT_NO,
                    'CAR_TYPE' => $model->CAR_TYPE,
                    'PLATE1' => $model->PLATE1,
                    'PLATE2' => $model->PLATE2
                ]);
            }
            
            // สำหรับ action อื่นๆ
            return Url::to([
                $action,
                'OFF_CODE' => $model->OFF_CODE,
                'BR_CODE' => $model->BR_CODE,
                'CAR_TEST_TYPE' => $model->CAR_TEST_TYPE,
                'CERT_YEAR' => $model->CERT_YEAR,
                'CERT_NO' => $model->CERT_NO,
                'CAR_TYPE' => $model->CAR_TYPE,
                'PLATE1' => $model->PLATE1,
                'PLATE2' => $model->PLATE2
            ]);
        },
        'buttons' => [
            'index-report-schedule' => function ($url, $model, $key) {
                return Html::a(
                    '<i class="fa fa-list"></i> บันทึกข้อมูล', 
                    $url, 
                    [
                        'title' => 'รายงานการทดสอบ',
                        'data-toggle' => 'tooltip',
                        'class' => 'btn btn-sm btn-primary',
                        'data-pjax' => '0',
                        'data-original-title' => 'รายงานการทดสอบ',
                    ]
                );
            },
        ],
        'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip', 'class' => 'btn btn-sm btn-warning'],
        'updateOptions' => [
            'role' => 'modal-remote',
            'title' => 'Update',
            'data-toggle' => 'tooltip',
            'class' => 'btn btn-sm btn-primary',
            'data-original-title' => 'Update',
            'icon' => '<i class="fa fa-edit"></i> บันทึกข้อมูล',
        ],
        'deleteOptions' => [
            'role' => 'modal-remote',
            'title' => 'Delete',
            'class' => 'btn btn-sm btn-outline-danger',
            'data-confirm' => false,
            'data-method' => false,
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Delete',
            'data-confirm-message' => 'Delete Confirm'
        ],
    ],

];
