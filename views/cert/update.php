<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MacTestVehCert $model */

$this->title = 'Update Mac Test Veh Cert: ' . $model->OFF_CODE;
$this->params['breadcrumbs'][] = ['label' => 'Mac Test Veh Certs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->OFF_CODE, 'url' => ['view', 'OFF_CODE' => $model->OFF_CODE, 'BR_CODE' => $model->BR_CODE, 'CAR_TEST_TYPE' => $model->CAR_TEST_TYPE, 'CERT_YEAR' => $model->CERT_YEAR, 'CERT_NO' => $model->CERT_NO]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mac-test-veh-cert-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
