<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VehTestReportSchedule */
?>
<div class="veh-test-report-schedule-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'OFF_CODE',
            'BR_CODE',
            'CAR_TEST_TYPE',
            'CERT_YEAR',
            'CERT_NO',
            'PLATE1',
            'PLATE2',
            'PLATE_SEQ',
            'report_date',
            'report_month',
            'report_status',
            'actual_report_date',
            'is_fined',
            'fine_amount',
            'fine_payment_status',
            'fine_payment_date',
            'fine_receipt_no',
            'remarks:ntext',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
