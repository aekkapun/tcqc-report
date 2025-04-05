<?php

use yii\helpers\Html;
use  kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'รายการบริษัท';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-index">

    <p>
        <?= Html::a('เพิ่มบริษัท', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                    'type' => 'primary', 
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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'company_registration_number',
            'company_name',
            'authorized_person',
            'email:email',
            'phone',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    $statusLabels = [
                        $model::STATUS_PENDING => 'รอตรวจสอบ',
                        $model::STATUS_APPROVED => 'อนุมัติแล้ว',
                        $model::STATUS_REJECTED => 'ไม่อนุมัติ',
                    ];
                    return $statusLabels[$model->status] ?? 'ไม่ระบุ';
                },
                'filter' => [
                    0 => 'รอตรวจสอบ',
                    1 => 'อนุมัติแล้ว',
                    2 => 'ไม่อนุมัติ',
                ],
                'contentOptions' => function ($model) {
                    $colors = [
                        $model::STATUS_PENDING => 'text-warning',
                        $model::STATUS_APPROVED => 'text-success',
                        $model::STATUS_REJECTED => 'text-danger',
                    ];
                    return ['class' => $colors[$model->status] ?? ''];
                },
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return Yii::$app->formatter->asDatetime($model->created_at);
                },
                'filter' => false,
            ],

            [
                'class' => 'kartik\grid\ActionColumn',
                'buttonOptions'=>['class'=>'btn btn-sm btn-default'],
                'template'=>'<div class="btn-group btn-group-sm text-center" role="group">{view} {update} {delete} </div>',
                'options'=> ['style'=>'width:150px;'],
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('ดูรายละเอียด', $url, [
                            'title' => 'ดูรายละเอียด',
                            'data-pjax' => 0,
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('แก้ไข', $url, [
                            'title' => 'แก้ไข',
                            'data-pjax' => 0,
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('ลบ', $url, [
                            'title' => 'ลบ',
                            'data-confirm' => 'คุณแน่ใจหรือไม่ที่จะลบรายการนี้?',
                            'data-method' => 'post',
                            'data-pjax' => 0,
                        ]);
                    },
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

<style>
    .text-success {
        color: #28a745;
    }

    .text-warning {
        color: #ffc107;
    }

    .text-danger {
        color: #dc3545;
    }
</style>