<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VehTestReportSchedule */
?>
<div class="veh-test-report-schedule-update">

    <?= $this->render('_form', [
        'model' => $model,
        'detailModel'=>$detailModel
    ]) ?>

</div>
