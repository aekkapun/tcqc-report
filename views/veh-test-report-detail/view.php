<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\VehTestReportDetail */
?>
<div class="veh-test-report-detail-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'schedule_id',
            'test_date_from',
            'test_date_to',
            'test_distance',
            'test_time',
            'test_location:ntext',
            'test_purpose:ntext',
            'test_result:ntext',
            'report_file',
            'remarks:ntext',
            'created_at',
            'updated_at',
            'created_by',
            'updated_by',
        ],
    ]) ?>

</div>
