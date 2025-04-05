<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap5\Modal;
use kartik\grid\GridView;
use yii2ajaxcrud\ajaxcrud\CrudAsset;
use yii2ajaxcrud\ajaxcrud\BulkButtonWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MacTestVehCertDetailSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายงานการใช้เครื่องหมายแสดงการใช้รถทดสอบ';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="mac-test-veh-cert-detail-index">
    <div class="card">
        <div class="card-body">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>

    <p>
        <?= Html::a('เพิ่มรถทดสอบ', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('สร้างกำหนดการรายงานทั้งหมด', ['veh-test-report/create-report-schedule-all'], [
            'class' => 'btn btn-primary',
            'id' => 'create-all-schedules',
            'data' => [
                'confirm' => 'ต้องการสร้างกำหนดการรายงานสำหรับรถทดสอบทั้งหมดที่ยังไม่หมดอายุหรือไม่?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'pjax' => true,
            'columns' => require(__DIR__ . '/_columns.php'),
            'toolbar' => [
                [
                    'content' =>
                    Html::a(
                        '<i class="fa fa-file-excel-o"></i> Report Excel',
                        array_merge(['export'], Yii::$app->request->getQueryParams()),
                        ['class' => 'btn btn-success', 'data-pjax' => 0]
                    ) . ' ' .
                        Html::a(
                            '<i class="fa fa-redo"></i>',
                            [''],
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
                'type' => 'primary',
                'heading' => '<i class="fa fa-list"></i> ' . $this->title,
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

        ]) ?>
    </div>
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