<?php

use app\models\MacTestVehCertDetailReport;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\MacTestVehCertDetailReportSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'รายงานการใช้เครื่องหมายแสดงการใช้รถทดสอบ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mac-test-veh-cert-detail-report-index">


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'pjax' => true,
            'columns' => require(__DIR__.'/_columns.php'),
            'toolbar' => [
        ['content' =>
            Html::a('<i class="fa fa-file-excel-o"></i> Report Excel', 
                array_merge(['export'], Yii::$app->request->getQueryParams()), 
                ['class' => 'btn btn-success', 'data-pjax' => 0]
            ) . ' ' .
            Html::a('<i class="fa fa-redo"></i>', [''], 
                ['data-pjax' => 1, 'class' => 'btn btn-outline-success', 'title' => 'Reset Grid']
            ) . ' ' .
            '{toggleData}'
        ],
            ],          
            'striped' => true,
            'hover' => true,
            'condensed' => true,
            'responsive' => true,          
            'panel' => [
                'type' => 'success', 
                'heading' => '<i class="fa fa-list"></i> '.$this->title,                  
                'before' => '', // ลบข้อความ Summary ออก
                'size' => 'large', // เพิ่มการตั้งค่าขนาดเป็น large
            ],
            'summary' => 'แสดง {begin}-{end} รายการ จากทั้งหมด {totalCount} รายการ',
        'pager' => [
        'firstPageLabel' => 'หน้าแรก',   // ปุ่มไปหน้าแรก
        'lastPageLabel' => 'หน้าสุดท้าย', // ปุ่มไปหน้าสุดท้าย
        'maxButtonCount' => 10,           // จำนวนเลขหน้าที่แสดง
    ],
    'panelFooterTemplate' => '{pager} {summary} <hr/>หมายเหตุ เครื่องหมาย * เป็นรายการที่แจ้งยกเลิกการใช้งานแล้ว', // แสดง page size + สรุปข้อมูล
    'layout' => "{items}\n{summary}\n{pager}",   // กำหนด layout ใหม่ให้แสดงตัวเลือก page size
    //'layout' => "{items}\n{pager}",   // กำหนด layout ใหม่ให้แสดงตัวเลือก page size

        ])?>

    <?php Pjax::end(); ?>

</div>
