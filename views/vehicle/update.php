<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MacTestVehCertDetail $model */

$this->title = 'Update Mac Test Veh Cert Detail: ' . $model->OFF_CODE;
$this->params['breadcrumbs'][] = ['label' => 'Mac Test Veh Cert Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->OFF_CODE, 'url' => ['view', 'OFF_CODE' => $model->OFF_CODE, 'BR_CODE' => $model->BR_CODE, 'CAR_TEST_TYPE' => $model->CAR_TEST_TYPE, 'CERT_YEAR' => $model->CERT_YEAR, 'CERT_NO' => $model->CERT_NO, 'CAR_TYPE' => $model->CAR_TYPE, 'PLATE1' => $model->PLATE1, 'PLATE2' => $model->PLATE2]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mac-test-veh-cert-detail-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
