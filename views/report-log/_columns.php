<?php
use yii\helpers\Url;

return [
[
    'class' => 'yii\grid\SerialColumn',
    'header' => 'ลำดับ',
    'headerOptions' => ['class' => 'text-center'], // จัดกึ่งกลางหัวข้อคอลัมน์
    'contentOptions' => ['class' => 'text-center'], // จัดกึ่งกลางค่าภายในคอลัมน์
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
                'label'=>'เลขที่หนังสืออนุญาต',
                'attribute'=>'CERT_NO',
                'value' => function ($model, $key, $index) {
                    return $model->certNo;
                },
            ],
            [
                'label'=>'ประเภทรถ',
                'value' => function ($model, $key, $index) {
                    return $model->carType;
                },
            ],
            [
                'label'=>'เครื่องหมาย',
                'format'=>'html',
                'attribute'=>'PLATE2',
                'value' => function ($model, $key, $index) {
                    return $model->plate;
                },
            ],
            // 'PLATE_SEQ',
            'NUM_BODY',
           // 'NUM_ENG',
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
            [
                'label'=>'วันที่บันทึก',
                'value' => function ($model, $key, $index) {
                    return Yii::$app->formatter->asDatetime($model->REPORT_DATE);
                },
            ],   
];   