<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MacTestVehCertDetailReport $model */

$this->title = 'Update Mac Test Veh Cert Detail Report: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Mac Test Veh Cert Detail Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'ID' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mac-test-veh-cert-detail-report-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
